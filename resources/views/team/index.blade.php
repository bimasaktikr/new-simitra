@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Daftar Tim</h1>

    <div class="mt-6">
        <div id="team-table" class="bg-gray-100 p-4 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            @include('team.table')
        </div>
    </div>
</div>

@endsection
