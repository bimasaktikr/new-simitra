<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-5">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">NIP</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($employees->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Pegawai tidak ditemukan.</td>
            </tr>
        @else
            @foreach($employees as $index => $employee)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">{{ $employees->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $employee['name'] }}</td>
                    <td class="px-6 py-4">{{ $employee['nip'] }}</td>
                    <td class="px-6 py-4">{{ $employee['email'] }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button onclick="window.location='{{ route('pegawaidetail', $employee->id) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                            <button onclick="window.location='{{ route('editpegawai', $employee->id) }}'" class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                        <div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $employees->links() }}

