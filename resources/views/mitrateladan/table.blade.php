<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
        <tr>
            <th scope="col" class="px-6 py-3">Ranking</th>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">ID Sobat</th>
            <th scope="col" class="px-6 py-3">Rating</th>
            <th scope="col" class="px-6 py-3">Banyak Survey</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leaderboards as $index => $leaderboard)
        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
            <td class="px-6 py-4">{{ $index + 1 + (request()->get('page', 1) - 1) * request()->get('per_page', 10) }}</td>
            <td class="px-6 py-4">{{ $leaderboard['name'] }}</td>
            <td class="px-6 py-4">{{ $leaderboard['id_sobat'] }}</td>
            <td class="px-6 py-4">{{ $leaderboard['rating'] ?? '-' }}</td>
            <td class="px-6 py-4">{{ $leaderboard['banyak_survey'] ?? '0' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
