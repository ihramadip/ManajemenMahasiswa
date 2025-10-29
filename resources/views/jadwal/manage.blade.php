<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Semua Jadwal</h3>
                        <a href="{{ route('jadwal.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] transition duration-150">
                            Tambah Jadwal Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-300 font-sans text-sm">
                            <thead class="bg-[#40916C]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Hari</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Waktu</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Mata Kuliah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Dosen</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Ruangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Semester</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tahun Akademik</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jadwals as $index => $jadwal)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-green-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $jadwal->hari }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                            {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $jadwal->mataKuliah->nama_mk }} ({{ $jadwal->mataKuliah->kode_mk }})</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $jadwal->dosen->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $jadwal->ruangan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $jadwal->semester }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $jadwal->tahun_akademik }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium space-x-2">
                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-[#40916C] hover:text-green-700 font-semibold">Edit</a>
                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jadwal yang tersedia untuk dikelola.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
