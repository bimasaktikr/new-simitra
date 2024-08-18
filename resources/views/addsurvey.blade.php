@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Survei</h1>

    <form action="{{ route('survei.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Survei</label>
            <input type="text" name="nama" id="nama" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="kode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Survei</label>
            <input type="text" name="kode" id="kode" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="ketua_tim" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ketua Tim</label>
            <input type="text" name="ketua_tim" id="ketua_tim" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Berakhir</label>
            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="tipe_pembayaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Pembayaran</label>
            <select name="tipe_pembayaran" id="tipe_pembayaran" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                <option value="bulanan">Bulanan</option>
                <option value="per_dokumen">Per Dokumen</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
            <input type="number" name="harga" id="harga" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Import Mitra (CSV atau XLS)</label>
            <input type="file" name="file" id="file" class="mt-1 block w-full p-2 border rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500">
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
