@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Pegawai</h1>

    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pegawai</label>
            <input type="text" name="nama" id="nama" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
            <input type="text" name="nip" id="nip" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="jk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
            <input type="text" name="jk" id="jk" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="text" name="email" id="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="fungsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fungsi</label>
            <select name="fungsi" id="fungsi" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                <option value="distribusi">Distribusi</option>
                <option value="ipds">IPDS</option>
                <option value="neraca">Neraca</option>
                <option value="produksi">Produksi</option>
                <option value="sosial">Sosial</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="peran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peran</label>
            <select name="fungsi" id="fungsi" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                <option value="ketua_tim">Ketua tim</option>
                <option value="anggota">Anggota</option>
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