<x-app-layout>
    <x-slot name="header">
        Input Nilai Mahasiswa
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Schedule Selection Form -->
                    <div class="mb-6">
                        <form action="{{ route('nilai.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="mata_kuliah_id" class="block text-sm font-medium text-gray-700">Pilih Mata Kuliah:</label>
                                <select id="mata_kuliah_id" name="mata_kuliah_id" class="mt-1 block w-full md:w-80 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md" onchange="this.form.submit()">
                                    <option value="">-- Semua Mata Kuliah --</option>
                                    @foreach($mataKuliahs as $matakuliah)
                                        <option value="{{ $matakuliah->id }}" {{ $selectedMataKuliahId == $matakuliah->id ? 'selected' : '' }}>
                                            {{ $matakuliah->nama_mk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jadwal_id" class="block text-sm font-medium text-gray-700">Pilih Jadwal:</label>
                                <select id="jadwal_id" name="jadwal_id" class="mt-1 block w-full md:w-96 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md">
                                    <option value="">-- Pilih Jadwal --</option>
                                    @foreach($jadwals as $jadwal)
                                        <option value="{{ $jadwal->id }}" {{ $selectedJadwalId == $jadwal->id ? 'selected' : '' }}>
                                            {{ $jadwal->mataKuliah->nama_mk }} - {{ $jadwal->hari }}, {{ $jadwal->waktu_mulai }} - {{ $jadwal->tahun_akademik }} / {{ $jadwal->semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] disabled:opacity-25 transition ease-in-out duration-150">
                                Tampilkan Mahasiswa
                            </button>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Grade Input Form -->
                    @if($selectedJadwalId && $krsDetails->count() > 0)
                        <form action="{{ route('nilai.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jadwal_id" value="{{ $selectedJadwalId }}">

                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                Daftar Mahasiswa - {{ $selectedJadwal->mataKuliah->nama_mata_kuliah }} ({{ $selectedJadwal->hari }}, {{ $selectedJadwal->waktu_mulai }})
                            </h3>

                            <!-- Search Input -->
                            <div class="mb-4">
                                <input type="text" id="searchInput" class="mt-1 block w-full md:w-1/2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md" placeholder="Cari berdasarkan NIM atau Nama Mahasiswa...">
                            </div>

                            <div class="overflow-x-auto rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-300 font-sans text-sm" id="mahasiswaTable">
                                    <thead class="bg-[#40916C]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">NIM</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Mahasiswa</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($krsDetails as $index => $detail)
                                            <tr class="student-row {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-green-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 nim">{{ $detail->krs->mahasiswa->nim ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 student-name">{{ $detail->krs->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="hidden" name="nilai[{{ $index }}][krs_detail_id]" value="{{ $detail->id }}">
                                                    <select name="nilai[{{ $index }}][nilai]" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-[#40916C] focus:border-[#40916C] sm:text-sm rounded-md">
                                                        <option value="">--Pilih--</option>
                                                        @foreach(['A', 'B', 'C', 'D', 'E'] as $grade)
                                                            <option value="{{ $grade }}" {{ old('nilai.'.$index.'.nilai', $detail->nilai->nilai ?? '') == $grade ? 'selected' : '' }}>
                                                                {{ $grade }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#40916C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#40916C] disabled:opacity-25 transition ease-in-out duration-150">
                                    Simpan Nilai
                                </button>
                            </div>
                        </form>

                        <script>
                            document.getElementById('searchInput').addEventListener('keyup', function() {
                                let filter = this.value.toLowerCase();
                                let table = document.getElementById('mahasiswaTable');
                                let rows = table.getElementsByClassName('student-row');

                                for (let i = 0; i < rows.length; i++) {
                                    let nimCell = rows[i].getElementsByClassName('nim')[0];
                                    let nameCell = rows[i].getElementsByClassName('student-name')[0];
                                    if (nimCell || nameCell) {
                                        let nimText = nimCell.textContent || nimCell.innerText;
                                        let nameText = nameCell.textContent || nameCell.innerText;
                                        if (nimText.toLowerCase().indexOf(filter) > -1 || nameText.toLowerCase().indexOf(filter) > -1) {
                                            rows[i].style.display = "";
                                        } else {
                                            rows[i].style.display = "none";
                                        }
                                    }
                                }
                            });
                        </script>

                    @elseif($selectedJadwalId)
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada mahasiswa yang terdaftar pada jadwal ini.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
