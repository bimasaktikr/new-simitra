@extends('layout.app')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="bg-white border border-gray-200 rounded-lg p-8 md:p-12 mb-8 dark:bg-gray-800 dark:border-gray-700">
            <h1 class="text-gray-900 dark:text-white text-4xl md:text-4xl font-extrabold mb-2">
                <strong>Selamat Datang, {{ ucfirst($userData->name) }}!</strong>
            </h1>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mt-4 mb-3">
                Penyedia Data Berkualitas Untuk Indonesia Maju
            </p>
            <!-- <a href="#" class="inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Read more
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a> -->
        </div>

        <div class="grid grid-cols-1 mb-8 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-lg rounded-lg p-8 flex flex-col justify-center items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Total Pengguna</h2>
                <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</p>
            </div>

            <!-- Total Mitra -->
            <div class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-lg rounded-lg p-8 flex flex-col justify-center items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Total Pegawai</h2>
                <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $totalPegawai }}</p>
            </div>

            <!-- Total Pegawai -->
            <div class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-lg rounded-lg p-8 flex flex-col justify-center items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Total Mitra</h2>
                <p class="text-4xl font-bold text-yellow-600 dark:text-yellow-400">{{ $totalMitra }}</p>
            </div>

            <!-- Total Survei -->
            <div class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-lg rounded-lg p-8 flex flex-col justify-center items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Total Survei</h2>
                <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $totalSurveys }}</p>
            </div>
        </div>
        
        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg">
        <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400 border border-gray-100 dark:border-gray-700">
            <li class="w-full focus-within:z-10">
                <a href="{{ route('dashboard', ['period' => 'all-time']) }}" class="inline-block w-full p-4 {{ $period == 'all-time' ? ' active dark:bg-gray-700 dark:text-white text-gray-900 bg-gray-100 border-r' : 'text-gray-500 dark:text-gray-400 bg-white border-r dark:bg-gray-800' }} border-gray-100 dark:border-gray-700 rounded-s-lg hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:hover:bg-gray-700">Semua</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('dashboard', ['period' => 'q1']) }}" class="inline-block w-full p-4 {{ $period == 'q1' ? ' dark:bg-gray-700 dark:text-white text-gray-900 bg-gray-100 border-r' : 'text-gray-500 dark:text-gray-400 bg-white border-r dark:bg-gray-800' }} border-gray-100 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:hover:bg-gray-700">Triwulan 1</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('dashboard', ['period' => 'q2']) }}" class="inline-block w-full p-4 {{ $period == 'q2' ? ' dark:bg-gray-700 dark:text-white text-gray-900 bg-gray-100 border-r' : 'text-gray-500 dark:text-gray-400 bg-white border-r dark:bg-gray-800' }} border-gray-100 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:hover:bg-gray-700">Triwulan 2</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('dashboard', ['period' => 'q3']) }}" class="inline-block w-full p-4 {{ $period == 'q3' ? ' dark:bg-gray-700 dark:text-white text-gray-900 bg-gray-100 border-r' : 'text-gray-500 dark:text-gray-400 bg-white border-r dark:bg-gray-800' }} border-gray-100 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:hover:bg-gray-700">Triwulan 3</a>
            </li>
            <li class="w-full focus-within:z-10">
                <a href="{{ route('dashboard', ['period' => 'q4']) }}" class="inline-block w-full p-4 {{ $period == 'q4' ? ' dark:bg-gray-700 dark:text-white text-gray-900 bg-gray-100 border-r' : 'text-gray-500 dark:text-gray-400 bg-white border-r dark:bg-gray-800' }} border-gray-100 dark:border-gray-700 hover:text-gray-700 rounded-e-lg hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:hover:bg-gray-700">Triwulan 4</a>
            </li>
        </ul>
        
        <div class="grid grid-cols-3 gap-4 max-w-full w-full rounded-lg shadow p-4 md:p-6 bg-gray-100 dark:bg-gray-700">
        
    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between items-start w-full">
            <div class="flex-col items-center">
            <div class="flex items-center mb-1">
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Proporsi Survei</h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Berdasarkan Fungsi</p>
                </div>
                <div data-popover id="chart-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                    <div class="p-3 space-y-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Activity growth - Incremental</h3>
                        <p>Report helps navigate cumulative growth of community activities. Ideally, the chart should have a growing trend, as stagnating chart signifies a significant decrease of community activity.</p>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Calculation</h3>
                        <p>For each date bucket, the all-time volume of activities is calculated. This means that activities in period n contain all activities up to period n, plus the activities generated by your community in period.</p>
                        <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg></a>
                </div>
                <div data-popper-arrow></div>
            </div>
            </div>
        </div>
        <div class="flex justify-end items-center">
            
        </div>
        </div>

        <!-- Line Chart -->
        <div class="py-6" id="pie-chart"></div>

        
        </div>
  
        
        
        
        <!-- Bagian Bar Chart -->
            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mr-8">
                <div class="flex justify-between pb-4 mb-4">
                    <div class="flex items-center">
                        <div>
                            <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Total Survei</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Berdasarkan Fungsi</p>
                        </div>
                    </div>
                    
                </div>

                <div id="column-chart"></div>
                <div class="grid grid-cols-1 items-center justify-center">
                    <div class="flex justify-center items-center pt-5">
                        
                    </div>
                </div>
            </div>

            <!-- Bagian Progress Bar -->
            <div class="max-w-sm w-full bg-white rounded-lg shadow p-4 md:p-6 dark:bg-gray-800 dark:text-white">
                <div class="flex justify-between mb-3">
                    <div class="flex items-center">
                        <div class="flex justify-center items-center">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Progress Penilaian Mitra</h5>
                            <!-- Circular Progress -->
                            <div class="relative size-40">
                                <svg class="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Background Circle -->
                                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-gray-200 dark:text-neutral-300" stroke-width="2"></circle>
                                    <!-- Progress Circle -->
                                    <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-600 dark:text-blue-500" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="{{ 100 - $overallPercentage }}" stroke-linecap="round"></circle>
                                </svg>
                                <!-- Percentage Text -->
                                <div class="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <span class="text-center text-2xl font-bold text-blue-600 dark:text-blue-500">{{ number_format($overallPercentage, 0) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bars -->
                <div class="space-y-4">
                    @foreach ($progressData as $teamId => $data)
                    <div class="flex flex-col space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-700 dark:text-white">{{ $data['name'] }}</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-white">{{ number_format($data['percentage'], 0) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-200">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>    
    document.addEventListener('DOMContentLoaded', function () {
        const progressData = @json($progressData); // Mengubah data dari PHP menjadi JSON
        
        // Transformasi data menjadi format yang diperlukan untuk grafik
        const series = Object.values(progressData).map(team => team.totalSurveysTeam);
        const labels = Object.values(progressData).map(team => team.name);

        const options = {
            series: series,
            labels: labels,
            colors: ["#1C64F2", "#16BDCA", "#9061F9", "#FFA500", "#CE2029"], 
            chart: {
                height: 420,
                width: "100%",
                type: "pie",
            },
            stroke: {
                colors: ["white"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    labels: {
                        show: true,
                    },
                    size: "100%",
                    dataLabels: {
                        offset: -25
                    }
                },
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        };

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart"), options);
            chart.render();
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const progressData = @json($progressData); // Mengubah data dari PHP menjadi JSON
        
        const options = {
            colors: ["#F77F00", "#1A56DB", "#FDBA8C"],
            series: [
                {
                    name: "Total Survei",
                    data: Object.keys(progressData).map(teamId => ({
                        x: progressData[teamId].name,
                        y: progressData[teamId].totalSurveysTeam
                    }))
                }
            ],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadiusApplication: "end",
                    borderRadius: 8,
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            xaxis: {
                floating: false,
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
            },
            fill: {
                opacity: 1,
            },
        };

        if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("column-chart"), options);
            chart.render();
        }
    });

</script>

@endsection
