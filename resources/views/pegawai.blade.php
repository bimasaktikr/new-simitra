@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Daftar Pegawai</h1>

    <div class="mt-6">
        <div class="flex justify-between mb-4">

            <div class="relative w-1/3">
                <input type="text" id="search" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" placeholder="Search..." />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            
            <div class="flex space-x-4">
                <button onclick="window.location='{{ route('addpegawai') }}'" class="inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                    Tambah Pegawai
                </button>
            </div>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-md">
 
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $employee)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $employee['name'] }}</td>
                            <td class="px-6 py-4">{{ $employee['nip'] }}</td>
                            <td class="px-6 py-4">{{ $employee['email'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button onclick="window.location='{{ route('pegawaidetail', ['id' => $index + 1]) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                                    <button onclick="window.location='{{ route('editpegawai') }}'" class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                                    <button onclick="" class="flex items-center justify-center w-10 h-10 text-red-600 rounded-full hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-between mt-4 items-center">
            <div>
                <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Records per halaman:</label>
                <select id="per_page" name="per_page" class="p-2 border rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
            </div>

            <div>
                <nav class="flex justify-end">
                    <ul class="inline-flex items-center -space-x-px">
                        <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">Previous</a></li>
                        <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">1</a></li>
                        <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">2</a></li>
                        <li><a href="#" class="px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
