<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Dosen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dosen.update', $dosen) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $dosen->nama_lengkap)" required autofocus />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <!-- NIDN -->
                        <div class="mt-4">
                            <x-input-label for="nidn" :value="__('NIDN')" />
                            <x-text-input id="nidn" class="block mt-1 w-full" type="text" name="nidn" :value="old('nidn', $dosen->nidn)" required />
                            <x-input-error :messages="$errors->get('nidn')" class="mt-2" />
                        </div>

                        <!-- Program Studi -->
                        <div class="mt-4">
                            <x-input-label for="prodi" :value="__('Program Studi')" />
                            <x-text-input id="prodi" class="block mt-1 w-full" type="text" name="prodi" :value="old('prodi', $dosen->prodi)" required />
                            <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dosen.index') }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
