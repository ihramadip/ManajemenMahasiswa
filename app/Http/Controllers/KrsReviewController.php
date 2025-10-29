<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KrsReviewController extends Controller
{
    /**
     * Display a listing of the KRS submissions that need review.
     */
    public function index()
    {
        $dosen = Auth::user();

        // Get pending KRS submissions
        $pendingKrs = Krs::where('dosen_pembimbing_id', $dosen->id)
                            ->where('status', 'submitted')
                            ->with('mahasiswa.user') // Eager load mahasiswa data
                            ->latest()
                            ->paginate(10, ['*'], 'pending_page');

        // Get approved KRS submissions
        $approvedKrs = Krs::where('dosen_pembimbing_id', $dosen->id)
                            ->where('status', 'approved')
                            ->with('mahasiswa.user') // Eager load mahasiswa data
                            ->latest()
                            ->paginate(10, ['*'], 'approved_page');

        return view('krs.review.index', compact('pendingKrs', 'approvedKrs'));
    }

    /**
     * Display the specified KRS for review.
     */
    public function show(Krs $krs)
    {
        // Authorization check: ensure the logged-in dosen is the advisor for this KRS
        if ($krs->dosen_pembimbing_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $krs->load(['mahasiswa.user', 'jadwals.mataKuliah', 'jadwals.dosen']);

        return view('krs.review.show', compact('krs'));
    }

    /**
     * Approve the specified KRS.
     */
    public function approve(Krs $krs)
    {
        if ($krs->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $krs->update(['status' => 'approved']);

        $mahasiswa = $krs->mahasiswa;

        if ($mahasiswa && $mahasiswa->user_id) {
            Notification::create([
                'user_id' => $mahasiswa->user_id,
                'message' => 'KRS Anda telah disetujui oleh Dosen Pembimbing.',
                'link' => route('krs.index')
            ]);
        } else {
            // Log an error if the student relationship is broken
            Log::error("Gagal membuat notifikasi persetujuan KRS: Relasi mahasiswa tidak ditemukan atau user_id kosong.", [
                'krs_id' => $krs->id,
                'mahasiswa_id_in_krs' => $krs->mahasiswa_id,
            ]);
        }

        return redirect()->route('krs.review.index')->with('success', 'KRS telah disetujui.');
    }

    /**
     * Reject the specified KRS.
     */
    public function reject(Request $request, Krs $krs)
    {
        if ($krs->dosen_pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'catatan_revisi' => 'required|string|max:500',
        ]);

        $krs->update([
            'status' => 'rejected',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        // Create notification for the student
        Notification::create([
            'user_id' => $krs->mahasiswa->user_id,
            'message' => 'KRS Anda ditolak. Silakan periksa catatan revisi.',
            'link' => route('krs.index')
        ]);

        return redirect()->route('krs.review.index')->with('success', 'KRS telah ditolak.');
    }
}