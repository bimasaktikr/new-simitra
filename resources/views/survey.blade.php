@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Daftar Survei</h1>

    <div class="mt-6">
        <div class="flex justify-between mb-4">
            <div class="relative w-1/3">
                <input type="text" id="search-survey" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            
            <div class="flex space-x-4">
                <form method="GET" action="{{ route('survei') }}">
                    <select name="status" id="status" onchange="this.form.submit()" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="sedang berlangsung" {{ request('status') == 'sedang berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="sudah berakhir" {{ request('status') == 'sudah berakhir' ? 'selected' : '' }}>Sudah Berakhir</option>
                    </select>
                </form>
                <button onclick="window.location='{{ route('addsurvei') }}'" class="inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                    Tambah Survei
                </button>
            </div>
        </div>

        <div id="survey-table" class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            @include('surveytable')
        </div>

        <form action="{{ route('survei') }}" method="GET">
            <div class="flex justify-between mt-4 items-center">
                <div>
                    <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Records per halaman:</label>
                    <select id="per_page" name="per_page" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" onchange="this.form.submit()">
                        <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request()->get('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request()->get('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>

                <div>
                    {{ $surveys->appends(['per_page' => request()->get('per_page', 10)])->links('components.pagination') }}
                </div>
            </div>
        </form>

    </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Apakah Anda yakin?</h2>
        <p class="mb-6 text-gray-700 dark:text-gray-300">Anda tidak dapat mengembalikan data yang telah dihapus.</p>
        <div class="flex justify-end">
            <button type="button" onclick="toggleModal('deleteModal')" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                Tidak
            </button>
            <button type="button" id="confirmDeleteButton" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Form Delete -->
<form id="deleteForm" action="" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection
