@extends('layout.app')

@section('content')
<div class="container p-4 mx-auto">
    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-100">Mitra Teladan</h1>


    <div class="mt-6">
        <!-- Filter Form -->
        <form action="{{ route('mitrateladan.index') }}" method="GET" class="flex mb-4 space-x-4">
            <!-- Year Dropdown -->
            <div class="w-1/3">
                <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
                <select id="year" name="year" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Select Year</option>
                    <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                    <!-- Add more years as needed -->
                </select>
            </div>

            <!-- Quarter Dropdown -->
            <div class="w-1/3">
                <label for="quarter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quarter</label>
                <select id="quarter" name="quarter" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="">Select Quarter</option>
                    <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Q1</option>
                    <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Q2</option>
                    <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Q3</option>
                    <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Q4</option>
                </select>   
            </div>

            <!-- Submit Button -->
            <div class="flex items-end w-1/3">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Generate Data
                </button>
            </div>
        </form>        
        
       

        <div class="p-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
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
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedByTeam as $mitra)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $mitra['mitra_id'] ?? $mitra['id'] }}</td>
                            
                            <!-- Check if 'mitra_name' exists -->
                            <td class="px-6 py-4">
                                @if (isset($mitra['mitra_name']))
                                    {{ $mitra['mitra_name'] }}
                                @else
                                    {{ $mitra['mitra']['name'] ?? 'Unknown' }}
                                @endif
                            </td>
                            
                            <!-- Check if 'average_rerata' exists and format it, else use 'avg_rating' -->
                            <td class="px-6 py-4">
                                {{ isset($mitra['average_rerata']) ? number_format((float)$mitra['average_rerata'], 2) : number_format((float)$mitra['avg_rating'], 2) }}
                            </td>
                            
                            <!-- Check if 'distinct_survey_count' exists, else use 'surveys_count' -->
                            <td class="px-6 py-4">
                                {{ $mitra['distinct_survey_count'] ?? $mitra['surveys_count'] }}
                            </td>
                            
                            <!-- Team ID -->
                            <td class="px-6 py-4">{{ $mitra['team_id'] }}</td>
                            
                            <!-- Action Button -->
                            <td class="px-6 py-4">
                                <button type="button"
                                        class="accept-btn font-medium rounded-lg text-sm px-5 py-2.5
                                               @if(isset($mitra['status']))
                                                   bg-gray-500 text-gray-200 cursor-not-allowed
                                               @else
                                                   bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                               @endif"
                                        data-mitra-id="{{ $mitra['mitra_id'] ?? $mitra['id'] }}"
                                        data-mitra-name="{{ $mitra['mitra_name'] ?? ($mitra['mitra']['name'] ?? 'Unknown') }}"
                                        data-mitra-rating="{{ isset($mitra['average_rerata']) ? number_format((float)$mitra['average_rerata'], 2) : number_format((float)$mitra['avg_rating'], 2) }}"
                                        data-mitra-surveys="{{ $mitra['distinct_survey_count'] ?? $mitra['surveys_count'] }}"
                                        data-mitra-team="{{ $mitra['team_id'] }}"
                                        @if(isset($mitra['status'])) disabled @endif>
                                    @if(isset($mitra['status']))
                                        Accepted
                                    @else
                                        Accept
                                    @endif
                                </button>
                            </td>
                            
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle year dropdown item click
        document.querySelectorAll('#dropdownHover .dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const value = this.getAttribute('data-value');
                document.getElementById('selectedYear').value = value;
                document.getElementById('dropdownHoverButton').textContent = `Pilih Tahun (${value})`;
            });
        });

        // Handle quarter dropdown item click
        document.querySelectorAll('#dropdowntrimesterHover .dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const value = this.getAttribute('data-value');
                document.getElementById('selectedQuarter').value = value;
                document.getElementById('dropdownTriwulanButton').textContent = `Pilih Triwulan (${value})`;
            });
        });

        // Handle accept button click for each mitra
        document.querySelectorAll('.accept-btn').forEach(button => {
            button.addEventListener('click', function() {
                const mitraId = this.getAttribute('data-mitra-id');
                const row = this.closest('tr');
                const mitraName = this.getAttribute('data-mitra-name');
                const rating = this.getAttribute('data-mitra-rating');
                const surveyCount = this.getAttribute('data-mitra-surveys');
                const teamId = this.getAttribute('data-mitra-team');
                const year = document.getElementById('year').value;
                const quarter = document.getElementById('quarter').value;
                const quarterInt = parseInt(quarter, 10);
                // SweetAlert confirmation
                Swal.fire({
                    title: 'Confirm Mitra Selection',
                    text: `Apakah anda yakin memilih ${mitraName} (ID: ${mitraId}) sebagai Mitra Terbaik Tim ${teamId} ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, select it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with sending the data to the server
                        fetch('/addmitrateladan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF protection
                            },
                            body: JSON.stringify({
                                mitra_id: mitraId,
                                mitra_name: mitraName,
                                rating: rating,
                                survey_count: surveyCount,
                                team_id: teamId,
                                year: year,
                                quarter: quarterInt
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                // If response is not ok (e.g., 500, 400), throw an error
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {

                            console.log(data);

                            if (data.success === true) {
                                Swal.fire(
                                    'Success!',
                                    `${mitraName} has been selected as the top mitra.`,
                                    'success'
                                );

                                // Optionally add the row to another table or update the UI
                                // addToMitraTeladanTable(mitraId, mitraName, rating, surveyCount, teamId);
                            } else {
                                Swal.fire(
                                    'Error',
                                    'There was a problem selecting this mitra. Please try again.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'There was a server error. Please try again later.',
                                'error'
                            );
                            console.error('Error:', error); // Log the error for 
                            console.log('Swal alert should be shown now.');
                        });
                    }
                });
            });
        });
    });

   
</script>

@endsection