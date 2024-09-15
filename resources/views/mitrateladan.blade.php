@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Mitra Teladan</h1>


    <div class="mt-6">
        <div class="flex justify-left mb-4 gap-2">
            
        <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" 
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" 
                type="button">Pilih Tahun
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
        </button>
            
        <!-- Dropdown menu -->
            <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">2024</a>
                    </li>
                </ul>
            </div>
    
            <div class=" w-1/3">
                <button id="dropdownTriwulanButton" data-dropdown-toggle="dropdowntrimesterHover" data-dropdown-trigger="hover" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    Pilih Triwulam
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                
                <!-- Dropdown menu -->
                <div id="dropdowntrimesterHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">I (satu)</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">II (dua)</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">III (tiga)</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">IV (Empat)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">Ranking</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">ID Sobat</th>
                            <th scope="col" class="px-6 py-3">Rating</th>
                            <th scope="col" class="px-6 py-3">Banyak Survey</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaderboards as $index => $leaderboard)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $index + 1}}</td>
                            <td class="px-6 py-4">{{ $leaderboard['name'] }}</td>
                            <td class="px-6 py-4">{{ $leaderboard['id_sobat'] }}</td>
                            <td class="px-6 py-4">{{ $leaderboard['rating'] ?? '-' }}</td>
                            <td class="px-6 py-4">{{ number_format($leaderboard['banyak_survey']), 2 ?? '0' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br>
    
        <form action="{{ route('mitrateladan') }}" method="GET">
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
                    {{ $mitras->appends(['per_page' => request()->get('per_page', 10)])->links('components.pagination') }}
                </div>
            </div>
        </form>

    </div>
</div>
@endsection