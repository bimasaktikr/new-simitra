<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Mitra</th>
            <th scope="col" class="px-6 py-3">Survei</th>
            <th scope="col" class="px-6 py-3">Kode Survei</th>
            <th scope="col" class="px-6 py-3">Target</th>
            <th scope="col" class="px-6 py-3">Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @if($transactions->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Transaksi tidak ditemukan.</td>
            </tr>
        @else
            @foreach($transactions as $index => $transaction)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $transactions->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $transaction->mitra_name }}</td>
                    <td class="px-6 py-4">{{ $transaction->survey_name }}</td>
                    <td class="px-6 py-4">{{ $transaction->survey_code }}</td>
                    <td class="px-6 py-4">{{ $transaction->target }}</td>
                    <td class="px-6 py-4">{{ $transaction->payment }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $transactions->links() }}

