

@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Mitra Teladan</h1>

    <div class="flex flex-wrap justify-center gap-4 mb-8">
        @forelse ($topMitraPerTeam as $mitra)
        <div class="w-1/6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-center">
            <div class="py-8">
                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white mb-1">{{ $mitra->name }}</h5>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $mitra->team }}</p>
                <div class="flex flex-col items-center mt-2.5 mb-5">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tahap 1: <span class="text-sm font-semibold tracking-tight text-gray-900 dark:text-white">{{ number_format($mitra->average_rating, 2) }}</span></p>
                    
                </div>
                <button onclick="window.location='{{ route('penilaian2.create', ['mitra_id' => $mitra->id_sobat, 'team' => $mitra->team_id]) }}'" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Nilai</button>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 dark:text-gray-400">No mitras qualified for stage 2 evaluation in this period.</p>
        @endforelse
    </div>

    <!-- Search and Period Filter Form -->
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

    <!-- Tabs for Selecting Period -->
    <div class="w-full border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <ul class="flex flex-wrap text-sm font-medium text-center dark:bg-gray-900 dark:border-gray-700 border-b border-gray-200 rounded-t-lg bg-gray-50" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
            <li> 
                <a href="{{ route('mitrateladan', ['period' => 'all-time']) }}" class="inline-block py-4 px-8 {{ $period == 'all-time' ? 'text-blue-500 dark:text-blue-400 bg-gray-100 dark:bg-gray-700' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} rounded-ss-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    Semua
                </a> 
            </li> 
            <li> 
                <a href="{{ route('mitrateladan', ['period' => 'q1']) }}" class="inline-block py-4 px-8 {{ $period == 'q1' ? 'text-blue-500 dark:text-blue-400 bg-gray-100 dark:bg-gray-700' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 1
                </a> 
            </li> 
            <li> 
                <a href="{{ route('mitrateladan', ['period' => 'q2']) }}" class="inline-block py-4 px-8 {{ $period == 'q2' ? 'text-blue-500 dark:text-blue-400 bg-gray-100 dark:bg-gray-700' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 2
                </a> 
            </li> 
            <li> 
                <a href="{{ route('mitrateladan', ['period' => 'q3']) }}" class="inline-block py-4 px-8 {{ $period == 'q3' ? 'text-blue-500 dark:text-blue-400 bg-gray-100 dark:bg-gray-700' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 3
                </a> 
            </li> 
            <li> 
                <a href="{{ route('mitrateladan', ['period' => 'q4']) }}" class="inline-block py-4 px-8 {{ $period == 'q4' ? 'text-blue-500 dark:text-blue-400 bg-gray-100 dark:bg-gray-700' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }} hover:bg-gray-100 dark:hover:bg-gray-700">
                    Triwulan 4
                </a> 
            </li> 
        </ul>

        <!-- Section for Individual Leaderboard -->
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
                        @foreach ($individualLeaderboards as $index => $leaderboard)
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

            <!-- Pagination for the Individual Leaderboard -->
            <div class="m-4">
                {{ $individualLeaderboards->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

    <!-- Records per page selector -->
    <form action="{{ route('mitrateladan') }}" method="GET">
        <div class="flex mt-4 items-center">
            <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Records per halaman:</label>
            <select id="per_page" name="per_page" class="ml-2 p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" onchange="this.form.submit()">
                <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request()->get('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request()->get('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>
        </div>
    </form>
</div>
@endsection
