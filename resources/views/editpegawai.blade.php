@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Pegawai</h1>

    <form action="{{ route('editpegawai.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pegawai</label>
            <input type="text" name="nama" id="nama" value="{{ old('name', $employee->name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $employee->nip) }}"
                class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 bg-gray-200 text-gray-500 cursor-not-allowed"
                readonly required>
        </div>

        <div class="mb-4">
            <label for="jk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
            <select name="jk" id="jk" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" required>
                <option value="Laki-laki" {{ $employee->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $employee->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>        
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email', $employee->email) }}"
                class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 bg-gray-200 text-gray-500 cursor-not-allowed"
                readonly required>
        </div>

        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $employee->tanggal_lahir->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="fungsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fungsi</label>
            <select name="fungsi" id="fungsi" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('name', $employee->team_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach 
            </select>
        </div>

        <div class="mb-4">
            <label for="peran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
            <select name="peran" id="peran" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                <option value="Ketua-tim" {{ $employee->peran == 'Ketua-tim' ? 'selected' : '' }}>Ketua tim</option>
                <option value="Anggota" {{ $employee->peran == 'Anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                Back
            </button>

            <button type="submit" class="px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection