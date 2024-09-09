@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Daftar Pegawai</h1>

    <div class="mt-6">
        <div class="flex justify-between mb-4">

            <div class="relative w-1/3">
                <input type="text" id="search-employee" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400" placeholder="Search..." />
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

        <div id="employee-table" class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            @include('pegawaitable')
        </div>

        <form action="{{ route('pegawai') }}" method="GET">
            <div class="flex justify-between mt-4 items-center">
                <div>
                    <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Records per halaman:</label>
                    <select id="per_page" name="per_page" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" onchange="this.form.submit()">
                        <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request()->get('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request()->get('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>

                <!-- <div>
                    {{ $employees->appends(['per_page' => request()->get('per_page', 10)])->links('components.pagination') }}
                </div> -->
            </div>
        </form>
    </div>
</div>

@endsection
