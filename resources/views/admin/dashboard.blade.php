<x-app-layout>
    <x-slot name="header">
        Dashboard Admin
    </x-slot>

    {{-- Welcome Banner --}}
    <div class="p-6 bg-white shadow-md rounded-lg mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin!</h2>
        <p class="text-gray-600">Pantau dan kelola sistem E-Akademik Anda.</p>
    </div>

    {{-- Statistik Sistem --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalMahasiswa }}</p>
            </div>
            <i class="fas fa-user-graduate fa-3x text-blue-500"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Dosen</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalDosen }}</p>
            </div>
            <i class="fas fa-chalkboard-teacher fa-3x text-green-500"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Mata Kuliah</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalMataKuliah }}</p>
            </div>
            <i class="fas fa-book fa-3x text-purple-500"></i>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users fa-3x text-red-500"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Tindakan Menunggu Persetujuan --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Tindakan Menunggu Persetujuan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-yellow-50 p-4 rounded-lg flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pengajuan KRS Menunggu</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $pendingKrsCount }}</p>
                        </div>
                        <i class="fas fa-file-signature fa-2x text-yellow-500"></i>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pesan Kontak Baru</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $newContactMessagesCount }}</p>
                        </div>
                        <i class="fas fa-envelope fa-2x text-blue-500"></i>
                    </div>
                </div>
            </div>

            {{-- Pengumuman Terbaru --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Pengumuman Terbaru</h3>
                <ul class="space-y-3">
                    @forelse ($latestPengumuman as $pengumuman)
                        <li class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
                            <div>
                                <a href="#" class="font-semibold text-gray-800 hover:text-blue-600">{{ $pengumuman->judul }}</a>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}</p>
                            </div>
                            <i class="fas fa-bullhorn text-gray-400"></i>
                        </li>
                    @empty
                        <li class="text-center py-4 text-gray-500">
                            <p>Tidak ada pengumuman terbaru.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Akses Cepat Manajemen --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Akses Cepat Manajemen</h3>
                <div class="space-y-3">
                    <a href="{{ route('users.index') }}" class="flex items-center w-full text-left p-4 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
                        <i class="fas fa-users-cog fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen User</span>
                    </a>
                    <a href="{{ route('mahasiswa.index') }}" class="flex items-center w-full text-left p-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-user-graduate fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen Mahasiswa</span>
                    </a>
                    <a href="{{ route('dosen.index') }}" class="flex items-center w-full text-left p-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-chalkboard-teacher fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen Dosen</span>
                    </a>
                    <a href="{{ route('matakuliah.index') }}" class="flex items-center w-full text-left p-4 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                        <i class="fas fa-book fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen Mata Kuliah</span>
                    </a>
                    <a href="{{ route('jadwal.manage') }}" class="flex items-center w-full text-left p-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                        <i class="fas fa-calendar-alt fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen Jadwal</span>
                    </a>
                    <a href="{{ route('pengumuman.index') }}" class="flex items-center w-full text-left p-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-bullhorn fa-lg mr-3"></i>
                        <span class="font-semibold">Manajemen Pengumuman</span>
                    </a>
                    <a href="{{ route('admin.reports.selection') }}" class="flex items-center w-full text-left p-4 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-file-alt fa-lg mr-3"></i>
                        <span class="font-semibold">Laporan</span>
                    </a>
                </div>
            </div>

            {{-- Pesan Kontak Terbaru --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-4 text-gray-800">Pesan Kontak Terbaru</h3>
                <ul class="space-y-3">
                    @forelse ($latestContactMessages as $message)
                        <li class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
                            <div>
                                <a href="#" class="font-semibold text-gray-800 hover:text-blue-600">{{ $message->subject }}</a>
                                <p class="text-xs text-gray-500">Dari: {{ $message->name }} ({{ $message->email }})</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</p>
                            </div>
                            <i class="fas fa-envelope-open-text text-gray-400"></i>
                        </li>
                    @empty
                        <li class="text-center py-4 text-gray-500">
                            <p>Tidak ada pesan kontak terbaru.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
