@extends('layout.app')

@section('content')
<div class="px-4 py-4 bg-white dark:bg-gray-900">
  <div class="px-4 sm:px-0">
    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-100">Detail Survei</h1>
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
  <div class="px-4 m-5 sm:px-0">
    <h3 class="text-xl font-bold leading-8 text-gray-900 dark:text-gray-100">Daftar Mitra</h3>
  </div>
  <div class="mt-6">
    <div class="flex justify-between mb-4">
      <div class="flex space-x-4">
        @if(!$survey->is_synced)
          <form action="{{ route('survei.sync', $survey->id) }}" method="POST">
              @csrf
              <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                  Sinkronisasi Data Mitra
              </button>
          </form>
        @endif
      </div>

      @if($survey->is_sudah_dinilai==0)
        <div class="flex space-x-4">
          <form action="{{ route('survei.finalisasi', $survey->id) }}" method="POST">
              @csrf
              @if($belumDinilai)
                <button class="px-4 py-2 ml-2 text-white bg-gray-400 border border-transparent rounded-lg shadow-sm cursor-not-allowed" disabled>Finalisasi Nilai</button>
              @else
                <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                Finalisasi Nilai
                </button>
              @endif
          </form>
        </div>
      @endif  
    </div>
  </div>

  <div class="p-4 bg-gray-100 rounded-lg shadow-md dark:bg-gray-700">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Id</th>
            <th scope="col" class="px-6 py-3">Mitra</th>
            <th scope="col" class="px-6 py-3">Nilai</th>
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
                            {{-- Tombol Nilai disable jika periode survei belum berakhir --}}
                            <button class="px-3 py-1 ml-2 text-white bg-gray-400 rounded cursor-not-allowed" disabled>Nilai</button>
                        @else
                            @php
                                // Cek apakah nilai sudah ada di tabel 'nilai' berdasarkan transaction_id
                                $nilai = \App\Models\Nilai1::where('transaction_id', $transaction->id)->first();
                            @endphp

                            @if ($survey->is_sudah_dinilai == 0)
                                @if (!$nilai)
                                    {{-- Tombol Nilai aktif jika survei sudah berakhir dan mitra belum dinilai --}}
                                    <button onclick="window.location='{{ route('penilaian.create', ['transaction_id' => $transaction->id]) }}'" class="px-3 py-1 ml-2 text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-500">
                                        Nilai
                                    </button>
                                @else
                                    {{-- Tampilkan nilai dan tombol edit jika survei sudah berakhir dan mitra sudah dinilai --}}
                                    <span>{{ $nilai->rerata }}</span>
                                    <button onclick="window.location='{{ route('penilaian.edit', ['transaction_id' => $transaction->id]) }}'" class="px-3 py-1 ml-2 text-white bg-yellow-500 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-500">
                                        Edit
                                    </button>
                                @endif
                            @else
                                {{-- Hanya tampilkan nilai jika survei sudah dinilai (is_sudah_dinilai == 1) --}}
                                @if ($nilai)
                                    <span>{{ $nilai->rerata }}</span>
                                @endif
                            @endif
                        @endif
                    </td>
                  </tr>
              @endforeach
        </tbody>
      </table>
    </div>
    
    <form action="{{ route('survei', $survey->id) }}" method="GET">
        <div class="flex items-center justify-between mt-4">
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
