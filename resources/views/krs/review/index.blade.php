<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Pengajuan KRS
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
                    <h3 class="text-lg font-semibold mb-4">Daftar KRS Menunggu Persetujuan</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md overflow-hidden">
                            <thead class="bg-[#40916C] text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">NIM</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">IPK</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Total SKS</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pendingKrs as $krs)
                                    <tr class="hover:bg-[#d8f3dc] transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $krs->mahasiswa->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $krs->mahasiswa->nim ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ number_format($krs->mahasiswa->ipk ?? 0, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $krs->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $krs->total_sks }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('krs.review.show', $krs) }}"
                                               class="text-[#40916C] hover:text-[#2D6A4F] p-2 rounded-md hover:bg-[#d8f3dc]"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada pengajuan KRS untuk direview.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $pendingKrs->links('pagination::tailwind', ['pageName' => 'pending_page']) }}
                    </div>

                    <!-- Approved KRS History Table -->
                    <div class="mt-10">
                        <h3 class="text-lg font-semibold mb-4">Riwayat KRS yang Telah Disetujui</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md overflow-hidden">
                                <thead class="bg-gray-600 text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Mahasiswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">NIM</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Disetujui</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Total SKS</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($approvedKrs as $krs)
                                        <tr class="hover:bg-gray-100 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $krs->mahasiswa->user->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $krs->mahasiswa->nim ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $krs->updated_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $krs->total_sks }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('krs.review.show', $krs) }}"
                                                   class="text-gray-600 hover:text-gray-900 p-2 rounded-md hover:bg-gray-200"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada KRS yang disetujui.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $approvedKrs->links('pagination::tailwind', ['pageName' => 'approved_page']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>