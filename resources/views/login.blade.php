<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Masuk SIMITRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .dark .bg-gray-900 {
            background-color: #1a202c;
        }
    </style>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var toggleIcon = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex min-h-screen flex-col justify-center items-center px-6 py-12 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-10 max-w-md w-full mx-auto">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-20 w-auto" src="/img/SIMITRA.png" alt="Logo SIMITRA">
                <h1 class="mt-10 text-center text-4xl font-bold leading-9 tracking-tight text-gray-900 dark:text-gray-100">SIMITRA</h1>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                @if(session('error'))
                <div class="alert alert-danger bg-red-100 text-red-800 p-4 rounded-lg dark:bg-red-800 dark:text-red-400">
                    <b>Opps!</b> {{session('error')}}
                </div>
                @endif
                <form class="space-y-6" action="{{ route('actionlogin') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Alamat Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required placeholder="Masukkan email Anda" class="block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-700 dark:ring-gray-600 dark:text-gray-300 dark:placeholder-gray-500 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Password</label>
                        </div>
                        <div class="mt-2 relative">
                            <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan password Anda" class="block w-full rounded-md border-0 py-1.5 px-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-700 dark:ring-gray-600 dark:text-gray-300 dark:placeholder-gray-500 sm:text-sm sm:leading-6">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i id="togglePassword" class="fas fa-eye text-gray-400 dark:text-gray-500"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-5 py-2 text-sm font-bold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-500">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
