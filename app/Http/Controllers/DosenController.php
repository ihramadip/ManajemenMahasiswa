<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosen = Auth::user();

        // Konversi hari ini ke dalam bahasa Indonesia
        $dayOfWeekMap = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $todayInIndonesia = $dayOfWeekMap[Carbon::now()->format('l')];

        // Jadwal Mengajar Hari Ini
        $jadwalHariIni = Jadwal::with('mataKuliah', 'krsDetails.krs.mahasiswa')
            ->where('dosen_id', $dosen->id)
            ->where('hari', $todayInIndonesia)
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // Daftar Mata Kuliah Diampu
        $mataKuliahDiampu = Jadwal::with('mataKuliah')
            ->where('dosen_id', $dosen->id)
            ->select('mata_kuliah_id', 'semester', 'tahun_akademik')
            ->distinct()
            ->get();

        // Mahasiswa Bimbingan Akademik
        $mahasiswaBimbingan = Mahasiswa::where('dosen_pembimbing_id', $dosen->id)->get();

        // Permintaan Persetujuan KRS (jika dosen adalah PA)
        $krsMenungguPersetujuan = Krs::where('dosen_pembimbing_id', $dosen->id)
            ->where('status', 'submitted')
            ->with('mahasiswa')
            ->get();

        // Pengumuman Terbaru
        $pengumumanTerbaru = Pengumuman::latest()->take(3)->get();

        // Data untuk Kartu Statistik
        $mahasiswaBimbinganCount = $mahasiswaBimbingan->count();
        $krsMenungguPersetujuanCount = $krsMenungguPersetujuan->count();
        $kelasAktifCount = $mataKuliahDiampu->count();

        // DEBUG INFO LANJUTAN
        $dosenIdDebug = $dosen->id;
        $totalJadwalDosenDebug = Jadwal::where('dosen_id', $dosen->id)->count();
        $jadwalRabuDosenDebug = Jadwal::where('dosen_id', $dosen->id)->where('hari', 'Rabu')->count();

        return view('dosen.dashboard', [
            'dosen' => $dosen,
            'jadwalHariIni' => $jadwalHariIni,
            'mataKuliahDiampu' => $mataKuliahDiampu,
            'mahasiswaBimbingan' => $mahasiswaBimbingan,
            'krsMenungguPersetujuan' => $krsMenungguPersetujuan,
            'pengumumanTerbaru' => $pengumumanTerbaru,
            'mahasiswaBimbinganCount' => $mahasiswaBimbinganCount,
            'krsMenungguPersetujuanCount' => $krsMenungguPersetujuanCount,
            'kelasAktifCount' => $kelasAktifCount,
            'todayInIndonesia' => $todayInIndonesia,
            'dosenIdDebug' => $dosenIdDebug,
            'totalJadwalDosenDebug' => $totalJadwalDosenDebug,
            'jadwalRabuDosenDebug' => $jadwalRabuDosenDebug,
        ]);
    }

    public function index(Request $request)
    {
        $query = Dosen::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%');
            });
        }

        $dosens = $query->oldest()->paginate(15);

        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'nama_lengkap' => 'required|string|max:255',
            'nidn' => 'required|string|max:20|unique:dosen,nidn',
            'prodi' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap,
            'nidn' => $request->nidn,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ]);

        return redirect()->route('dosen.index')->with('success', 'Dosen baru berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nidn' => 'required|string|max:20|unique:dosen,nidn,' . $dosen->id,
            'prodi' => 'required|string|max:255',
        ]);

        $dosen->update($request->all());

        // Also update the user's name if it's linked to nama_lengkap
        if ($dosen->user) {
            $dosen->user->update(['name' => $request->nama_lengkap]);
        }


        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        // The user associated with the dosen will be deleted automatically by the database cascade constraint
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}