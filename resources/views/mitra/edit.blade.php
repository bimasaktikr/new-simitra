@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Mitra</h1>

    <form action="{{ route('editmitra.update', $mitra->id_sobat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Mitra</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $mitra->name) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label for="id_sobat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID Sobat</label>
            <input type="text" name="id_sobat" id="id_sobat" value="{{ old('id_sobat', $mitra->id_sobat) }}"
                class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 bg-gray-200 text-gray-500 cursor-not-allowed"
                readonly required>
        </div>

        <div class="mb-4">
            <label for="jk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
            <select name="jk" id="jk" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" required>
                <option value="Laki-laki" {{ $mitra->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $mitra->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email', $mitra->email) }}"
                class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 bg-gray-200 text-gray-500 cursor-not-allowed"
                readonly required>
        </div>

        <div class="mb-4">
            <label for="pendidikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pendidikan</label>
            <input type="text" name="pendidikan" id="pendidikan" value="{{ old('pendidikan', $mitra->pendidikan) }}"  class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $mitra->tanggal_lahir->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" required>
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
