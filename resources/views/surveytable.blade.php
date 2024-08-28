<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Nama Survei</th>
            <th scope="col" class="px-6 py-3">Kode</th>
            <th scope="col" class="px-6 py-3">Tim</th>
            <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
            <th scope="col" class="px-6 py-3">Tanggal Berakhir</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($surveys->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Survei tidak ditemukan.</td>
            </tr>
        @else
            @foreach($surveys as $index => $survey)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $surveys->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $survey->name }}</td>
                    <td class="px-6 py-4">{{ $survey->code }}</td>
                    <td class="px-6 py-4">{{ $survey->team_name }}</td>
                    <td class="px-6 py-4">{{ $survey->start_date }}</td>
                    <td class="px-6 py-4">{{ $survey->end_date }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button onclick="window.location='{{ route('surveidetail', ['id' => $index + 1]) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                            <button onclick="window.location='{{ route('editsurvei', ['id' => $index + 1]) }}'" class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                            <button type="button" onclick="toggleModal('deleteModal', '{{ route('surveys.destroy', $survey->id) }}')" class="flex items-center justify-center w-10 h-10 text-red-600 rounded-full hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $surveys->links() }}

