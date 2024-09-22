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

            
            <div class="flex justify-between mb-6 space-x-4">
                @for ($teamId = 1; $teamId <= 5; $teamId++)
                    @php
                        // Find the team by 'team_id' from the grouped data
                        $team = collect($groupedByTeam)->firstWhere('team_id', $teamId);
                    @endphp
                    <div class="relative w-1/5 p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        @if ($team && array_key_exists('status', $team) && $team['status'] === 'final')
                            <!-- Display Image Based on mitra_id -->
                            <div class="flex flex-col items-center pb-10">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="/docs/images/people/profile-picture-3.jpg" alt="Bonnie image"/>
                                <h5 class="mt-4 mb-2 text-xl font-semibold text-center text-gray-900 dark:text-white">
                                    {{ $team['mitra']['name'] ?? 'Unknown' }}
                                </h5>
                                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Rating Tahap 1 : {{ $team['avg_rating_1'] }} | Surveys: {{ $team['surveys_count'] }}
                                </p>
                                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Rating Tahap 2 : <strong>{{ isset($team['avg_rating_2']) ? number_format((float)$team['avg_rating_2'], 2) : number_format((float)$team['nilai_2'], 2) }} </strong>
                                </p>
                                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Status Tahap 2 : {{ ($team['status_phase_2'] == 1) ? "Data Sudah Final" : "Data Belum Di Finalisasi" }}
                                </p>
                                <div class="flex justify-between mb-1 space-x-2 text-center">
                                    @for ( $team_penilai = 0  ;  $team_penilai < 6 ;  $team_penilai++ )
                                        @if ( $team['team_done']->contains($team_penilai + 1))
                                            @if ($team['is_final'][$team_penilai + 1] == 1)
                                                <p class="mb-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                                    ✅ Team {{ $team_penilai + 1 }}
                                                </p>
                                            @else
                                                <p class="mb-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                                    ✔️ Team {{ $team_penilai + 1 }}
                                                </p>
                                            @endif
                                        @else
                                            <p class="mb-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                                ❌ Team {{ $team_penilai + 1 }}
                                            </p>
                                        @endif
                                    @endfor
                                </div>
                                
                                <div class="flex flex-col mt-2 space-y-2 md:mt-6">
                                @if (isset($team['is_final'][auth()->user()->employee->team_id]) && $team['is_final'][auth()->user()->employee->team_id] == 1)
                                    <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg cursor-not-allowed disabled hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Nilai Sudah Final
                                    </a>
                                @else
                                    @if ($team['team_done']->contains(Auth::user()->employee->team_id))
                                        <a href="{{ route('penilaian2.edit', ['mitra_teladan_id' => $team['id']]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                            Edit Nilai
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('penilaian2.create', ['mitra_teladan_id' => $team['id']]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Nilai Tahap 2
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </a>
                                    @endif
                                @endif
            
                                @if (auth()->user()->role_id == 1)
                                    @if ($team['status_phase_2'] !== 1)
                                        <button 
                                            type="button"
                                            id="final-button"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg
                                            @if ($team['is_all_final'] == true)
                                                hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800
                                            @else hover:bg-blue-800 focus:ring-4 focus:outline-none cursor-not-allowed focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800
                                            @endif
                                            "                               
                                            @if ($team['is_all_final'] !== true)
                                                disabled 
                                            @endif
                                            data-team-id="{{ $team['id'] }}"
                                        >
                                            {{ $team['is_all_final'] == true ? 'Finalisasi Data' : 'Data Team Belum Final' }}
                                        </button>
                                    @else
                                        <button 
                                            type="button"
                                            onclick="confirmUnfinalButton()"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800 "
                                        >
                                            Unfinal Data
                                        </button>
                                    @endif
                                    
                                @endif
            
                                @if ($team['team_id'] == $winnerTeam)
                                    <div class="absolute top-0 right-0">
                                        <div class="w-32 h-8 top-4 -right-8">
                                            <div
                                                class="w-full h-full font-semibold leading-8 text-center text-white transform rotate-45 bg-red-500">
                                                WINNER</div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        @else
                            <!-- Placeholder for missing team -->
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Team ID: {{ $teamId }}</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                No data available for this team.
                            </p>
                        @endif
                    </div>
                @endfor
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
                                {{ isset($mitra['average_rerata']) ? number_format((float)$mitra['average_rerata'], 2) : number_format((float)$mitra['avg_rating_1'], 2) }}
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
                                            @if (Auth::user()->role_id == 1)
                                                @if (isset($mitra['status']))
                                                 bg-gray-500 text-gray-200 cursor-not-allowed
                                                @else
                                                bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                                @endif

                                            @elseif(Auth::user()->employee->team_id == $mitra['team_id'])
                                                @if (isset($mitra['status']))
                                                bg-gray-500 text-gray-200 cursor-not-allowed
                                                @else
                                                bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                                @endif
                                            @else
                                                bg-gray-500 text-gray-200 cursor-not-allowed
                                            @endif"
                                        data-mitra-id="{{ $mitra['mitra_id'] ?? $mitra['id'] }}"
                                        data-mitra-name="{{ $mitra['mitra_name'] ?? ($mitra['mitra']['name'] ?? 'Unknown') }}"
                                        data-mitra-rating="{{ isset($mitra['average_rerata']) ? number_format((float)$mitra['average_rerata'], 2) : number_format((float)$mitra['avg_rating_1'], 2) }}"
                                        data-mitra-surveys="{{ $mitra['distinct_survey_count'] ?? $mitra['surveys_count'] }}"
                                        data-mitra-team="{{ $mitra['team_id'] }}"
                                        @if (Auth::user()->role_id == 1)
                                            @if (isset($mitra['status']))
                                                disabled
                                            @endif
                                        @elseif(Auth::user()->employee->team_id == $mitra['team_id'])
                                            @if (isset($mitra['status']))
                                                disabled
                                            @endif
                                        @else
                                            disabled
                                        @endif">
                                        @if (Auth::user()->role_id == 1)
                                            @if (isset($mitra['status']))
                                                Accepted
                                            @else
                                                Accept
                                            @endif
                                        @elseif(Auth::user()->employee->team_id == $mitra['team_id'])
                                            @if (isset($mitra['status']))
                                                Accepted
                                            @else
                                                Accept
                                            @endif
                                        @else
                                            Not Authorized
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

        /**
         * Final Button
        */
        // Get all button elements with data-team-id attribute
        const buttons = document.querySelectorAll('[data-team-id]');

        // Attach event listener to each button
        buttons.forEach(button => {
            button.addEventListener('click', function(event) {
                const teamId = button.getAttribute('data-team-id');
                confirmFinalButton(teamId);
            });
        });

        function confirmFinalButton(mitraTeladanId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to finalize the evaluation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', 
                cancelButtonColor: '#d33', 
                confirmButtonText: 'Yes, confirm!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the finalization route with the ID
                    window.location.href = `/penilaian2/${mitraTeladanId}/final`;
                } else {
                    console.log('Finalization canceled');
                }
            });
        }
    });
</script>

@endsection