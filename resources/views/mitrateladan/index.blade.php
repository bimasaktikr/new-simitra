@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Mitra Teladan</h1>

    <form method="GET" action="{{ route('mitrateladan') }}" class="flex justify-between mb-4">
        <div class="relative w-1/3">
            <input type="text" id="search" name="search" value="{{ request()->get('search') }}" class="block w-full p-2 pl-10 text-sm border rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" placeholder="Search..." />
            <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
        <input type="hidden" id="selected-period" name="period" value="{{ $period }}">
        <button type="submit" class="p-2 text-white bg-blue-600 rounded">Cari</button>
    </form>

    <div class="w-full border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <ul class="flex flex-wrap text-sm font-medium text-center dark:bg-gray-900 dark:border-gray-700 border-b border-gray-200 rounded-t-lg bg-gray-50" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
            <li class="me-2"> 
                <a href="{{ route('mitrateladan', ['period' => 'all-time']) }}" class="inline-block p-4 {{ $period == 'all-time' ? 'text-gray-800 dark:text-gray-200' : 'hover:text-gray-600 dark:hover:text-gray-300' }} rounded-ss-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    All Time
                </a> 
            </li> 
            <li class="me-2"> 
                <a href="{{ route('mitrateladan', ['period' => 'q1']) }}" class="inline-block p-4 {{ $period == 'q1' ? 'text-gray-800 dark:text-gray-200' : 'hover:text-gray-600 dark:hover:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 1
                </a> 
            </li> 
            <li class="me-2"> 
                <a href="{{ route('mitrateladan', ['period' => 'q2']) }}" class="inline-block p-4 {{ $period == 'q2' ? 'text-gray-800 dark:text-gray-200' : 'hover:text-gray-600 dark:hover:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 2
                </a> 
            </li> 
            <li class="me-2"> 
                <a href="{{ route('mitrateladan', ['period' => 'q3']) }}" class="inline-block p-4 {{ $period == 'q3' ? 'text-gray-800 dark:text-gray-200' : 'hover:text-gray-600 dark:hover:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 3
                </a> 
            </li> 
            <li class="me-2"> 
                <a href="{{ route('mitrateladan', ['period' => 'q4']) }}" class="inline-block p-4 {{ $period == 'q4' ? 'text-gray-800 dark:text-gray-200' : 'hover:text-gray-600 dark:hover:text-gray-300' }} rounded-se-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 4
                </a> 
            </li> 
        </ul>

        <div id="defaultTabContent">
            <div class="overflow-hidden overflow-x-auto">
                <table id="leaderboard-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">ID Sobat</th>
                            <th scope="col" class="px-6 py-3">Rating</th>
                            <th scope="col" class="px-6 py-3">Banyak Survey</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaderboards as $index => $leaderboard)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $leaderboard['name'] }}</td>
                                <td class="px-6 py-4">{{ $leaderboard['id_sobat'] }}</td>
                                <td class="px-6 py-4">{{ $leaderboard['rating'] }}</td>
                                <td class="px-6 py-4">{{ $leaderboard['banyak_survey'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $leaderboards->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div> 

@endsection 
