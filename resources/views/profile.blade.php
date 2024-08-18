@extends('layout.app')

@section('content')

<div class="w-full border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <ul class="flex flex-wrap text-sm font-medium text-center dark:bg-gray-900 dark:border-gray-700 border-b border-gray-200 rounded-t-lg bg-gray-50" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
        <li class="me-2">
            <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true" class="inline-block p-4 text-gray-800 dark:text-gray-200 rounded-ss-lg hover:bg-gray-100 dark:hover:bg-gray-700">Detail Profil</button>
        </li>
        <li class="me-2">
            <button id="services-tab" data-tabs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false" class="inline-block p-4 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Ubah Password</button>
        </li>
    </ul>
    <div id="defaultTabContent">
        <!-- Detail Profil Tab -->
        <div class="hidden p-4 bg-white dark:bg-gray-900 rounded-lg md:p-8" id="about" role="tabpanel" aria-labelledby="about-tab">
            <!-- Gambar Profil -->
            <div class="mb-6">
                <img src="/img/user.png" alt="Profile Picture" class="w-32 h-32 rounded-full border-4 border-gray-700 object-cover">
            </div>

            <div class="mb-4">
                <p class="font-semibold text-gray-800 dark:text-gray-200">Nama Lengkap</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->name }}</p>
            </div>
            <div class="mb-4">
                <p class="font-semibold text-gray-800 dark:text-gray-200">Email</p>
                <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Ubah Password Tab -->
        <div class="hidden p-4 bg-white dark:bg-gray-900 rounded-lg md:p-8" id="services" role="tabpanel" aria-labelledby="services-tab">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 text-red-500 p-4 mb-4 rounded dark:bg-red-800 dark:text-red-400">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="bg-green-100 text-green-500 p-4 mb-4 rounded dark:bg-green-800 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-4 relative">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Lama</label>
                    <input type="password" id="current_password" name="current_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    <button type="button" class="absolute inset-y-0 right-0 px-3 py-2 flex items-center text-gray-600 dark:text-gray-400" id="toggleCurrentPassword" style="top: 45%;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div class="mb-4 relative">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    <button type="button" class="absolute inset-y-0 right-0 px-3 py-2 flex items-center text-gray-600 dark:text-gray-400" id="toggleNewPassword" style="top: 45%;">
                        <i class="fa-solid fa-eye"></i> 
                    </button>
                </div>
                <div class="mb-4 relative">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    <button type="button" class="absolute inset-y-0 right-0 px-3 py-2 flex items-center text-gray-600 dark:text-gray-400" id="toggleNewPasswordConfirmation" style="top: 45%;">
                        <i class="fa-solid fa-eye"></i> 
                    </button>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
        const currentPasswordInput = document.getElementById('current_password');
        
        const toggleNewPassword = document.getElementById('toggleNewPassword');
        const newPasswordInput = document.getElementById('new_password');
        
        const toggleNewPasswordConfirmation = document.getElementById('toggleNewPasswordConfirmation');
        const newPasswordConfirmationInput = document.getElementById('new_password_confirmation');
        
        function togglePasswordVisibility(input, button) {
            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<i class="fa-solid fa-eye-slash"></i>'; 
            } else {
                input.type = 'password';
                button.innerHTML = '<i class="fa-solid fa-eye"></i>'; 
            }
        }

        toggleCurrentPassword.addEventListener('click', function () {
            togglePasswordVisibility(currentPasswordInput, toggleCurrentPassword);
        });

        toggleNewPassword.addEventListener('click', function () {
            togglePasswordVisibility(newPasswordInput, toggleNewPassword);
        });

        toggleNewPasswordConfirmation.addEventListener('click', function () {
            togglePasswordVisibility(newPasswordConfirmationInput, toggleNewPasswordConfirmation);
        });
    });
</script>

@endsection
