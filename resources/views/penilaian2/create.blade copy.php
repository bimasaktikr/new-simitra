@extends('layout.app')

@section('content')
<div class="container px-4 py-6 mx-auto bg-white dark:bg-gray-900">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-100">Penilaian Survei</h1>

    <div class="p-6 mb-6 bg-gray-100 rounded-md shadow-md dark:bg-gray-800">
        <p class="pb-2 text-gray-900 dark:text-gray-100">Nama : {{ $mitra_teladan->mitra->name }}</p>
        <p class="pb-2 text-gray-900 dark:text-gray-100">Mitra Teladan Team  {{ $mitra_teladan->team->name }}</p>
        <p class="pb-2 text-gray-900 dark:text-gray-100">Tahun  {{ $mitra_teladan->year }} & Triwulan {{ $mitra_teladan->quarter }}</p>
    </div>

    <form action="{{ route('penilaian2.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mitra_teladan_id" value="{{ $mitra_teladan->id }}">
        
        <div class="p-6 bg-gray-100 rounded-md shadow-md dark:bg-gray-800">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400 bg-gray-50 dark:bg-gray-700">
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
                    @foreach ($penilaian2 as $key => $var )
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $var->variabel }}</td>
                            @for($i = 1; $i <= 5; $i++)
                                <td class="px-6 py-4 text-center">
                                    <input type="radio" name="aspek{{$key + 1}}" value="{{ $i }}" class="text-blue-600 form-radio dark:text-blue-400 required">
                                </td>
                            @endfor
                        </tr>
                    @endforeach
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
