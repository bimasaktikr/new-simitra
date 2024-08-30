<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">ID Sobat</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($mitras->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Mitra tidak ditemukan.</td>
            </tr>
        @else
            @foreach($mitras as $index => $mitra)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $mitras->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $mitra->name }}</td>
                    <td class="px-6 py-4">{{ $mitra->id_sobat }}</td>
                    <td class="px-6 py-4">{{ $mitra->email }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button onclick="window.location='{{ route('mitradetail', $mitra->id_sobat) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                            <button onclick="window.location='{{ route('editmitra', $mitra->id_sobat) }}'" class="ml-2 px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                            <button type="button" onclick="toggleModal('deleteModal', '{{ route('mitra.destroy', $mitra->id_sobat) }}')" class="flex items-center justify-center w-10 h-10 text-red-600 rounded-full hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $mitras->links() }}

