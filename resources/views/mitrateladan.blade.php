@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Mitra Teladan</h1>


    <div class="mt-6">
        <!-- Filter Form -->
        <form action="{{ route('mitrateladan.index') }}" method="GET" class="flex space-x-4 mb-4">
            <!-- Year Dropdown -->
            <div class="w-1/3">
                <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
                <select id="year" name="year" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Select Year</option>
                    <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                    <!-- Add more years as needed -->
                </select>
            </div>

            <!-- Quarter Dropdown -->
            <div class="w-1/3">
                <label for="quarter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quarter</label>
                <select id="quarter" name="quarter" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Select Quarter</option>
                    <option value="1" {{ request('quarter') == 'Q1' ? 'selected' : '' }}>Q1</option>
                    <option value="2" {{ request('quarter') == 'Q2' ? 'selected' : '' }}>Q2</option>
                    <option value="3" {{ request('quarter') == 'Q3' ? 'selected' : '' }}>Q3</option>
                    <option value="4" {{ request('quarter') == 'Q4' ? 'selected' : '' }}>Q4</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="w-1/3 flex items-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Generate Data
                </button>
            </div>
        </form>        
        
       

        <div class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
             <!-- Table Title -->
            <div class="mb-4">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Mitra Teladan Tahun {{ $year }} Triwulan  {{ $quarter }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status : </p>
            </div>

            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID Sobat</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Rating</th>
                            <th scope="col" class="px-6 py-3">Banyak Survey</th>
                            <th scope="col" class="px-6 py-3">Team</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mitras as $mitra)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="px-6 py-4">{{ $mitra['mitra_id'] }}</td>
                            <td class="px-6 py-4">{{ $mitra['mitra_name'] }}</td>
                            <td class="px-6 py-4">{{ number_format((float)$mitra['average_rerata'], 2) }}</td>
                            <td class="px-6 py-4">{{ $mitra['distinct_survey_count'] }}</td>
                            <td class="px-6 py-4">{{ $mitra['team_id'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br>
    
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle year dropdown item click
        document.querySelectorAll('#dropdownHover .dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const value = this.getAttribute('data-value');
                document.getElementById('selectedYear').value = value;
                // Optionally update button text
                document.getElementById('dropdownHoverButton').textContent = `Pilih Tahun (${value})`;
            });
        });
    
        // Handle trimester dropdown item click
        document.querySelectorAll('#dropdowntrimesterHover .dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const value = this.getAttribute('data-value');
                document.getElementById('selectedQuarter').value = value;
                // Optionally update button text
                document.getElementById('dropdownTriwulanButton').textContent = `Pilih Triwulan (${value})`;
            });
        });
    });
</script>
@endsection