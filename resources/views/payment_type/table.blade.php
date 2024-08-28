<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Tipe Pembayaran</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @if($paymentTypes->isEmpty())
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">Tipe pembayaran tidak ditemukan.</td>
            </tr>
        @else
            @foreach($paymentTypes as $index => $paymentType)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $paymentTypes->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $paymentType->payment_type }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button onclick="window.location='{{ route('editpaymenttype', $paymentType->id) }}'" class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800">Edit</button>
                            <button type="button" onclick="toggleModal('deleteModal', '{{ route('paymenttypes.destroy', $paymentType->id) }}')" class="flex items-center justify-center w-10 h-10 text-red-600 rounded-full hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $paymentTypes->links() }}

