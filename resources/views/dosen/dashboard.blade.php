<x-app-layout>
    <x-slot name="header">
        Dashboard Dosen
    </x-slot>

    {{-- Welcome Banner --}}
    <div class="p-6 bg-white shadow-md rounded-lg mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $dosen->name }}!</h2>
        <p class="text-gray-600">Semoga hari Anda produktif dalam mengajar dan membimbing.</p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <i class="fas fa-users fa-3x text-blue-500 mr-4"></i>
            <div>
                <p class="text-sm text-gray-500">Mahasiswa Bimbingan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $mahasiswaBimbinganCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <i class="fas fa-file-signature fa-3x text-yellow-500 mr-4"></i>
            <div>
                <p class="text-sm text-gray-500">KRS Perlu Direview</p>
                <p class="text-3xl font-bold text-gray-800">{{ $krsMenungguPersetujuanCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
            <i class="fas fa-chalkboard-teacher fa-3x text-green-500 mr-4"></i>
            <div>
                <p class="text-sm text-gray-500">Kelas Aktif</p>
                <p class="text-3xl font-bold text-gray-800">{{ $kelasAktifCount }}</p>
            </div>
        </div>
    </div>

    {{-- Main Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column (Main Content) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Widget: Jadwal Mengajar Hari Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Jadwal Mengajar Hari Ini</h3>
                <div class="space-y-4">
                    @forelse ($jadwalHariIni as $jadwal)
                        <div class="flex items-center p-4 border rounded-md bg-gray-50">
                            <div class="mr-4 text-center">
                                <p class="text-lg font-bold text-green-700">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</p>
                            </div>
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-700">{{ $jadwal->mataKuliah->nama_mk }}</p>
                                <p class="text-sm text-gray-500">{{ $jadwal->ruangan }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500">
                            <i class="fa-solid fa-mug-saucer fa-2x mb-2"></i>
                            <p>Tidak ada jadwal mengajar hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Widget: Permintaan Persetujuan KRS --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Permintaan Persetujuan KRS</h3>
                <ul class="space-y-3">
                    @forelse ($krsMenungguPersetujuan as $krs)
                        <li class="flex justify-between items-center p-3 bg-yellow-50 rounded-md">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $krs->mahasiswa->user->name }}</p>
                                <p class="text-sm text-gray-500">NIM: {{ $krs->mahasiswa->nim }}</p>
                            </div>
                            <a href="{{ route('krs.review.show', $krs->id) }}" class="text-sm font-bold text-yellow-800 bg-yellow-200 px-3 py-2 rounded-md hover:bg-yellow-300 transition-colors">Review</a>
                        </li>
                    @empty
                        <li class="text-center py-4 text-gray-500">
                            <p>Tidak ada permintaan KRS yang menunggu persetujuan.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>

        {{-- Right Column (Side Content) --}}
        <div class="space-y-6">

            {{-- Widget: Akses Cepat --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Akses Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('nilai.index') }}" class="flex items-center w-full text-left p-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-edit fa-lg mr-3"></i>
                        <span class="font-semibold">Input Nilai Mahasiswa</span>
                    </a>
                    <a href="{{ route('krs.review.index') }}" class="flex items-center w-full text-left p-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-file-signature fa-lg mr-3"></i>
                        <span class="font-semibold">Review Pengajuan KRS</span>
                    </a>
                    <a href="{{ route('jadwal.index') }}" class="flex items-center w-full text-left p-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-calendar-alt fa-lg mr-3"></i>
                        <span class="font-semibold">Lihat Jadwal Lengkap</span>
                    </a>
                </div>
            </div>

            {{-- Widget: Pengumuman Terbaru --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Pengumuman Terbaru</h3>
                <ul class="space-y-3">
                    @forelse ($pengumumanTerbaru as $pengumuman)
                        <li class="text-sm text-gray-700 hover:bg-gray-50 p-2 rounded">
                            <a href="#" class="font-bold text-gray-900">{{ $pengumuman->judul }}</a>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}</p>
                        </li>
                    @empty
                        <li class="text-center py-4 text-gray-500">
                            <p>Tidak ada pengumuman terbaru.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>

    </div>

</x-app-layout>
