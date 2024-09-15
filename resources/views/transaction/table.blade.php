<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-5">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Mitra</th>
            <th scope="col" class="px-6 py-3">Survei</th>
            <th scope="col" class="px-6 py-3">Kode Survei</th>
            <th scope="col" class="px-6 py-3">Target</th>
            <th scope="col" class="px-6 py-3">Pembayaran</th>
            <th scope="col" class="px-6 py-3">Rating</th>
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
                    <td class="px-6 py-4">{{ $transaction->mitra->name }}</td>
                    <td class="px-6 py-4">{{ $transaction->survey->name }}</td>
                    <td class="px-6 py-4">{{ $transaction->survey->code }}</td>
                    <td class="px-6 py-4">{{ $transaction->target }}</td>
                    <td class="px-6 py-4">{{ number_format($transaction->payment, 2) }}</td>
                    @if (isset($transaction->nilai1->rerate))
                        <td class="px-6 py-4">{{ $transaction->nilai1->rerata }}</td>
                    @else
                        <td class="px-6 py-4">Belum Ada Rating</td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $transactions->links() }}

