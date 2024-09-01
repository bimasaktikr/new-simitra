@extends('layout.app')

@section('content')
<div class="container mx-auto px-4 py-6 bg-white dark:bg-gray-900">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Penilaian Survei</h1>

    <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-md shadow-md mb-6">
        <p class="pb-2 text-gray-900 dark:text-gray-100"><strong>Mitra:</strong> {{ $mitra->name }}</p>
        <p class="pb-2 text-gray-900 dark:text-gray-100"><strong>Survei:</strong> {{ $survey->name }}</p>
    </div>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
        
        <div class="bg-gray-100 dark:bg-gray-800 p-6 rounded-md shadow-md">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">Variabel</th>
                        <th scope="col" class="px-6 py-3 text-center">Sangat Buruk</th>
                        <th scope="col" class="px-6 py-3 text-center">Buruk</th>
                        <th scope="col" class="px-6 py-3 text-center">Cukup</th>
                        <th scope="col" class="px-6 py-3 text-center">Baik</th>
                        <th scope="col" class="px-6 py-3 text-center">Sangat Baik</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">Kualitas Data</td>
                        @for($i = 1; $i <= 5; $i++)
                            <td class="px-6 py-4 text-center">
                                <input type="radio" name="kualitas_data" value="{{ $i }}" class="form-radio text-blue-600 dark:text-blue-400 required">
                            </td>
                        @endfor
                    </tr>
                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">Ketepatan Waktu</td>
                        @for($i = 1; $i <= 5; $i++)
                            <td class="px-6 py-4 text-center">
                                <input type="radio" name="ketepatan_waktu" value="{{ $i }}" class="form-radio text-blue-600 dark:text-blue-400 required">
                            </td>
                        @endfor
                    </tr>
                    <tr class="bg-white dark:bg-gray-900 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">Pemahaman Pengetahuan Kerja</td>
                        @for($i = 1; $i <= 5; $i++)
                            <td class="px-6 py-4 text-center">
                                <input type="radio" name="pemahaman_pengetahuan_kerja" value="{{ $i }}" class="form-radio text-blue-600 dark:text-blue-400 required">
                            </td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                Back
            </button>

            <button type="submit" class="px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                Kirim
            </button>
        </div>
    </form>
</div>
@endsection
