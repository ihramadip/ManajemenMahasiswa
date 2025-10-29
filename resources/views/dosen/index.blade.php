<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Dosen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form Pencarian --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4">
                        <form action="{{ route('dosen.index') }}" method="GET" class="flex flex-wrap items-center space-x-2">
                            <x-text-input 
                                type="text" 
                                name="search" 
                                placeholder="Cari Nama atau NIDN..." 
                                value="{{ request('search') }}" 
                                class="w-64" />

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] disabled:opacity-25 transition ease-in-out duration-150">
                                Cari
                            </button>

                            @if(request('search'))
                                <a href="{{ route('dosen.index') }}" class="text-[#40916C] hover:text-[#2D6A4F] text-sm underline">
                                    Reset
                                </a>
                            @endif
                        </form>

                        <a href="{{ route('dosen.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#2D6A4F] focus:outline-none focus:ring-2 focus:ring-[#40916C] focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Dosen Baru
                        </a>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md overflow-hidden">
                            <thead class="bg-[#40916C] text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">NIDN</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Program Studi</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($dosens as $dosen)
                                    <tr class="hover:bg-[#d8f3dc] transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->nama_lengkap }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->nidn }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $dosen->prodi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('dosen.edit', $dosen->id) }}" 
                                               class="text-[#40916C] hover:text-[#2D6A4F] p-2 rounded-md hover:bg-[#d8f3dc]" 
                                               title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 p-2 rounded-md hover:bg-red-100"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Menghapus data dosen juga akan menghapus akun user yang terkait.')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data dosen.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $dosens->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
