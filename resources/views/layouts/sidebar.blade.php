<!-- Alpine.js component -->
<aside x-data="{ isExpanded: false }" :class="isExpanded ? 'w-64' : 'w-20'" class="bg-[#081C15] flex flex-col items-center py-6 space-y-8 transition-all duration-300">
    
    <!-- Logo and Toggle Button -->
    <div class="w-full flex items-center" :class="isExpanded ? 'justify-between px-6' : 'justify-center'">
        <a href="{{ route('dashboard') }}" x-show="isExpanded">
            <h2 class="text-2xl font-bold tracking-wide text-[#B7E4C7]">E-Akademik</h2>
        </a>
        <a href="{{ route('dashboard') }}" x-show="!isExpanded">
            <div class="text-[#B7E4C7] text-3xl font-bold">E</div>
        </a>
        <button @click="isExpanded = !isExpanded" class="text-[#B7E4C7] hover:text-white">
            <i class="fas" :class="isExpanded ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex flex-col space-y-4 text-[#B7E4C7] w-full">
            <a href="{{ route('admin.dashboard') }}" title="Dashboard" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-home text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('users.index') }}" title="Manajemen User" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-users-cog text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Manajemen User</span>
            </a>
            <a href="{{ route('mahasiswa.index') }}" title="Data Mahasiswa" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('mahasiswa.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-user-graduate text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Data Mahasiswa</span>
            </a>
            <a href="{{ route('dosen.index') }}" title="Data Dosen" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('dosen.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-chalkboard-teacher text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Data Dosen</span>
            </a>
            <a href="{{ route('pengumuman.index') }}" title="Manajemen Pengumuman" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('pengumuman.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-bullhorn text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Manajemen Pengumuman</span>
            </a>
            <a href="{{ route('matakuliah.my_courses') }}" title="Mata Kuliah Diampu" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('matakuliah.my_courses') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-chalkboard-teacher text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Mata Kuliah Diampu</span>
            </a>
            <a href="{{ route('nilai.index') }}" title="Input Nilai" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('nilai.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-pen-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Input Nilai</span>
            </a>
            <a href="{{ route('krs.index') }}" title="KRS & Nilai" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('krs.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-graduation-cap text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Kartu Rencana Studi</span>
            </a>
            <a href="{{ route('jadwal.index') }}" title="Jadwal Kuliah" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-calendar-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Jadwal Kuliah</span>
            </a>
            <a href="{{ route('admin.reports.selection') }}" title="Laporan Mahasiswa" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-file-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Laporan Mahasiswa</span>
            </a>

        @if(Auth::user()->role == 'dosen')
            <a href="{{ route('dosen.dashboard') }}" title="Dashboard" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('dosen.dashboard') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-home text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('krs.review.index') }}" title="Persetujuan KRS" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('krs.review.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-file-signature text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Persetujuan KRS</span>
            </a>
            <a href="{{ route('matakuliah.my_courses') }}" title="Mata Kuliah Saya" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('matakuliah.my_courses') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-chalkboard-teacher text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Mata Kuliah</span>
            </a>
            <a href="{{ route('nilai.index') }}" title="Input Nilai" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('nilai.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-pen-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Input Nilai</span>
            </a>
            <a href="{{ route('jadwal.index') }}" title="Jadwal Kuliah" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-calendar-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Jadwal Kuliah</span>
            </a>

        @elseif(Auth::user()->role == 'mahasiswa')
            {{-- SIDEBAR MAHASISWA --}}
            <a href="{{ route('dashboard') }}" title="Dashboard" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-home text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('profile.edit') }}" title="Profil Saya" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-user text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Profil Saya</span>
            </a>
            <a href="{{ route('krs.index') }}" title="Kartu Rencana Studi (KRS)" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('krs.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-edit text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Isi KRS</span>
            </a>
            <a href="{{ route('khs.index') }}" title="Kartu Hasil Studi (KHS)" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('khs.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-poll text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Lihat KHS</span>
            </a>
            <a href="{{ route('jadwal.index') }}" title="Jadwal Kuliah" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-calendar-alt text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Jadwal Kuliah</span>
            </a>
            <a href="{{ route('reports.selection') }}" title="Laporan" class="flex items-center py-3 rounded-md hover:bg-[#40916C] hover:text-white transition-colors duration-300 {{ request()->routeIs('reports.*') ? 'bg-[#40916C] text-white' : '' }}" :class="isExpanded ? 'px-6' : 'justify-center'">
                <i class="fas fa-print text-xl w-8 text-center"></i>
                <span x-show="isExpanded" class="ml-4 font-semibold">Laporan</span>
            </a>
        @endif
    </nav>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-auto w-full">
        @csrf
        <a href="{{ route('logout') }}" 
        onclick="event.preventDefault(); this.closest('form').submit();" 
        title="Logout" 
        class="flex items-center py-3 rounded-md text-[#B7E4C7] hover:bg-red-500 hover:text-white transition-colors duration-300" :class="isExpanded ? 'px-6' : 'justify-center'">
            <i class="fas fa-sign-out-alt text-xl w-8 text-center"></i>
            <span x-show="isExpanded" class="ml-4 font-semibold">Logout</span>
        </a>
    </form>
</aside>
