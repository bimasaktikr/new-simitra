@extends('layout.app')

@section('content')
<div class="px-4 py-4 bg-white dark:bg-gray-900">
  <div class="px-4 sm:px-0">
    <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100">Detail Survei</h1>
  </div>
  <div class="mt-6 border-t border-gray-100 dark:border-gray-700">
    <dl class="divide-y divide-gray-100 dark:divide-gray-700">
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Nama Survei</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['name'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Kode</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['code'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tim</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['team_name'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tanggal Mulai</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['start_date'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tanggal Berakhir</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['end_date'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tipe Pembayaran</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['payment_type_name'] }}</dd>
      </div>
      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Harga</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ number_format($survey['payment'], 2) }}</dd>
      </div>
    </dl>
  </div>
  <div class="px-4 sm:px-0 m-5">
    <h3 class="text-base font-bold leading-8 text-gray-900 dark:text-gray-100">Daftar Mitra</h3>
  </div>
  <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
        <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-800">
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Id</th>
            <th scope="col" class="px-6 py-3">Mitra</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
              @foreach($transactions as $index => $transaction)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                      <td class="px-6 py-4">{{ $transactions->firstItem() + $index }}</td>
                      <td class="px-6 py-4">{{ $transaction->mitra_id }}</td>
                      <td class="px-6 py-4">{{ $transaction->mitra_name }}</td>
                      <td class="px-6 py-4">
                      @if (\Carbon\Carbon::now()->lessThan(\Carbon\Carbon::parse($survey['end_date'])))
                        <button class="ml-2 px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed" disabled>Nilai</button>
                      @else
                        <button onclick="window.location='{{ route('penilaian.create', ['transaction_id' => $transaction->id]) }}'" class="ml-2 px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-500">
                            Nilai
                        </button>
                      @endif
                    </td>
                  </tr>
              @endforeach
      </tbody>
      </table>
    </div>
    
    <form action="{{ route('survei', $survey->id) }}" method="GET">
        <div class="flex justify-between mt-4 items-center">
            <div>
                <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Records per halaman:</label>
                <select id="per_page" name="per_page" class="p-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" onchange="this.form.submit()">
                    <option value="10" {{ request()->get('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request()->get('per_page') == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request()->get('per_page') == 20 ? 'selected' : '' }}>20</option>
                </select>
            </div>

            <div>
                {{ $transactions->appends(['per_page' => request()->get('per_page', 10)])->links('components.pagination') }}
            </div>
        </div>
    </form>
  </div>
  
  <div class="flex justify-between mt-6">
    <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
      Back
    </button>
  </div>
</div>


@endsection
