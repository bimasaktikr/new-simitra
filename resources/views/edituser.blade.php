@extends('layout.app')

@section('content')
<div class="container mx-auto p-4 dark:bg-gray-900 dark:text-gray-200">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit User</h1>

    <form action="" method="PUT" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('name', $name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 bg-gray-200 text-gray-500 cursor-not-allowed"
                readonly required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
            <select name="role" id="role" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role', $user->role_id) == $role->id ? 'selected' : '' }}>
                    {{ $role->role }}
                </option>
            @endforeach    
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required>
                <option value="Aktif" {{ $user->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak aktif" {{ $user->status == 'Tidak aktif' ? 'selected' : '' }}>Tidak aktif</option>   
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                Back
            </button>

            <button type="submit" class="px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
