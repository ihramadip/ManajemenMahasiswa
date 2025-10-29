<x-app-layout>
    <x-slot name="header">
        Jadwal Kuliah
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <form action="{{ route('jadwal.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester:</label>
                                <select id="semester" name="semester" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md">
                                    <option value="">Semua Semester</option>
                                    @foreach(['Ganjil', 'Genap'] as $sem)
                                        <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="tahun_akademik" class="block text-sm font-medium text-gray-700">Tahun Akademik:</label>
                                <select id="tahun_akademik" name="tahun_akademik" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md">
                                    <option value="">Semua Tahun</option>
                                    @php
                                        $currentYear = date('Y');
                                        for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                            $yearRange = $i . '/' . ($i + 1);
                                            echo "<option value=\"{$yearRange}\" " . (request('tahun_akademik') == $yearRange ? 'selected' : '') . ">{$yearRange}</option>";
                                        }
                                    @endphp
                                </select>
                            </div>

                            @if(Auth::user()->hasRole('admin'))
                            <div>
                                <label for="dosen_id" class="block text-sm font-medium text-gray-700">Dosen:</label>
                                <select id="dosen_id" name="dosen_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md">
                                    <option value="">Semua Dosen</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] disabled:opacity-25 transition ease-in-out duration-150">
                                Filter
                            </button>

                            @if(Auth::user()->hasRole('admin'))
                            <div class="ml-auto">
                                <a href="{{ route('jadwal.manage') }}" class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] disabled:opacity-25 transition ease-in-out duration-150">
                                    Kelola Jadwal
                                </a>
                            </div>
                            @endif
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-300 font-sans text-sm">
                            <thead class="bg-[#40916C]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Waktu</th>
                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider" style="min-width: 180px;">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $timeSlots = [];
                                    foreach ($jadwals as $day => $dayJadwals) {
                                        foreach ($dayJadwals as $jadwal) {
                                            $timeSlot = date('H:i', strtotime($jadwal->waktu_mulai)) . ' - ' . date('H:i', strtotime($jadwal->waktu_selesai));
                                            if (!in_array($timeSlot, $timeSlots)) {
                                                $timeSlots[] = $timeSlot;
                                            }
                                        }
                                    }
                                    sort($timeSlots);
                                @endphp

                                @forelse($timeSlots as $index => $timeSlot)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-green-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $timeSlot }}</td>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                            <td class="px-6 py-4 whitespace-normal text-gray-700 align-top">
                                                @php
                                                    $filteredJadwals = collect($jadwals[$day] ?? [])->filter(function ($jadwal) use ($timeSlot) {
                                                        return (date('H:i', strtotime($jadwal->waktu_mulai)) . ' - ' . date('H:i', strtotime($jadwal->waktu_selesai))) == $timeSlot;
                                                    });
                                                @endphp

                                                @foreach($filteredJadwals as $jadwal)
                                                    <div class="mb-3 p-3 border border-[#40916C] rounded-lg bg-white shadow-sm hover:shadow-md transition">
                                                        <p class="font-semibold text-[#40916C]">{{ $jadwal->mataKuliah->nama_mk }} ({{ $jadwal->mataKuliah->kode_mk }})</p>
                                                        <p class="text-xs text-gray-600">Dosen: {{ $jadwal->dosen->name }}</p>
                                                        <p class="text-xs text-gray-600">Ruang: {{ $jadwal->ruangan }}</p>
                                                        <p class="text-xs text-gray-600">Semester: {{ $jadwal->semester }} ({{ $jadwal->tahun_akademik }})</p>
                                                    </div>
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada jadwal yang tersedia.</td>
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
