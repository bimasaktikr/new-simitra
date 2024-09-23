@extends('layout.app')

@section('content')
<div class="px-4 py-4 bg-white dark:bg-gray-900">
  <div class="px-4 sm:px-0">
    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-100">Detail Survei</h1>
  </div>
  <div class="mt-6 border-t border-gray-100 dark:border-gray-700">
    <dl class="divide-y divide-gray-100 dark:divide-gray-700">
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Nama Survei</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['name'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Kode</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['code'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tim</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['team_name'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tanggal Mulai</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['start_date'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tanggal Berakhir</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['end_date'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Tipe Pembayaran</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['payment_type_name'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Harga</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ number_format($survey['payment'], 2) }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Status</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ $survey['status'] }}</dd>
      </div>
      <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">File</dt>
        <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-300 sm:col-span-2 sm:mt-0">{{ isset($survey['file']) ? $survey['file'] : "Belum ada File" }}</dd>
      </div>
    </dl>
  </div>
  <div class="px-4 m-2 sm:px-0">
    <h3 class="text-xl font-bold leading-8 text-gray-900 dark:text-gray-100">Daftar Mitra</h3>
  </div>
  <div class="mt-2">
    <div class="flex justify-between mb-4">
      {{-- <div class="flex space-x-4">
        @if(!$survey->is_synced)
          <form action="{{ route('survei.sync', $survey->id) }}" method="POST">
              @csrf
              <button type="submit" class="inline-flex items-center px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                  Sinkronisasi Data Mitra
              </button>
          </form>
        @endif
      </div> --}}

      <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Data Mitra
        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
      </button>
        
        <!-- Dropdown menu -->
      <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
            <li>
              <a href="{{ route('download.mitratemplate') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Download Template</a>
            </li>
            <li>
              <button id="uploadMitraButton" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                Upload Data Mitra
              </button>
            </li>
          </ul>
      </div>
        
      @if($survey->is_sudah_dinilai==0)
        <div class="flex space-x-4">
          <form action="{{ route('survei.finalisasi', $survey->id) }}" method="POST">
              @csrf
<<<<<<< HEAD
              @if($belumDinilai || !$survey->is_synced)
=======
              @if($belumDinilai)
>>>>>>> dev
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
            <th scope="col" class="px-6 py-3">Nilai Aspek 1</th>
            <th scope="col" class="px-6 py-3">Nilai Aspek 2</th>
            <th scope="col" class="px-6 py-3">Nilai Aspek 3</th>
            <th scope="col" class="px-6 py-3">Nilai Rerata</th>
          </tr>
        </thead>
        <tbody>
              @foreach($transactions as $index => $transaction)
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                      <td class="px-6 py-4">{{ $transactions->firstItem() + $index }}</td>
                      <td class="px-6 py-4">{{ $transaction->mitra_id }}</td>
                      <td class="px-6 py-4">{{ $transaction->mitra_name }}</td>
                      <td class="px-6 py-4">{{ $transaction->nilai1->aspek1 }}</td>
                      <td class="px-6 py-4">{{ $transaction->nilai1->aspek2 }}</td>
                      <td class="px-6 py-4">{{ $transaction->nilai1->aspek3 }}</td>
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

<!-- The Modal -->
<!-- assume your modal element has an ID of "myModal" -->
<div id="uploadModal" class="fixed top-0 left-0 flex items-center justify-center hidden w-full h-full">
  <div class="max-w-md p-4 bg-white rounded shadow-md modal-content">
    <!-- your modal content here -->
    
    <div class="flex justify-between mb-4">
      <h2 class="text-lg font-bold">Upload Data Mitra</h2>
      <button class="text-gray-600 transition duration-300 ease-in-out hover:text-gray-900" aria-label="Close modal">
        <svg viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>

    <form id="uploadForm" action="{{ route('upload.mitradata', $survey->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('post')
      <input type="file" id="file" name="file" accept=".xlsx">
      <input type="hidden" name="_method" value="POST">
      <button type="submit">Upload</button>
      <div id="uploadProgress" class="progress"></div>
      <p id="uploadMessage"></p>
    </form>
    <!-- your modal content here -->
  </div>
</div>

@endsection

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
  const uploadButton = document.getElementById('uploadMitraButton');
  const surveyId = "{{ $survey['id']}}";
  const csrfToken = '{{ csrf_token() }}';
  const modal = document.getElementById('uploadModal');

  if (uploadButton) 
  {
    uploadButton.addEventListener('click', function() {
      console.log('Upload button clicked!');
      modal.classList.remove('hidden'); // Show the modal
    });
  } else {
    console.error('Upload button not found');
  }

});
</script>
  
@endsection