<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Dosen;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik Sistem
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();
        $totalUsers = User::count();

        // Tindakan Menunggu Persetujuan
        $pendingKrsCount = Krs::where('status', 'submitted')->count();
        $newContactMessagesCount = ContactUs::where('is_read', false)->count();

        // Aktivitas & Informasi Terbaru
        $latestPengumuman = Pengumuman::latest()->take(5)->get();
        $latestContactMessages = ContactUs::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMataKuliah',
            'totalUsers',
            'pendingKrsCount',
            'newContactMessagesCount',
            'latestPengumuman',
            'latestContactMessages'
        ));
    }
}
