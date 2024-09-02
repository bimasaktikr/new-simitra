<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Tim</th>
            <th scope="col" class="px-6 py-3">Ketua Tim</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($teams->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Tim tidak ditemukan.</td>
            </tr>
        @else
            @foreach($teams as $index => $team)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $teams->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $team->name }}</td>
                    <td class="px-6 py-4">{{ $team->ketua_tim }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button onclick="window.location='{{ route('teamdetail', $team->id) }}'" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-800">Lihat</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $teams->links() }}

