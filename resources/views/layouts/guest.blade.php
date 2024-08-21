<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 dark:bg-gray-900">
        <div class="flex min-h-screen flex-col justify-center items-center px-6 py-12 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-10 max-w-md w-full mx-auto">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-20 w-auto" src="/img/SIMITRA.png" alt="Logo SIMITRA">
                    <h1 class="mt-10 text-center text-4xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-100">SIMITRA</h1>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
