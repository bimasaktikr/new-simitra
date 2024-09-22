@extends('layout.app')

@section('content')
<div class="container px-4 py-6 mx-auto bg-white dark:bg-gray-900">
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-100">Penilaian Survei</h1>

    <div class="p-6 mb-6 bg-gray-100 rounded-md shadow-md dark:bg-gray-800">
        <p class="pb-2 text-gray-900 dark:text-gray-100">Nama : {{ $mitra_teladan->mitra->name }}</p>
        <p class="pb-2 text-gray-900 dark:text-gray-100">Mitra Teladan Team  {{ $mitra_teladan->team->name }}</p>
        <p class="pb-2 text-gray-900 dark:text-gray-100">Tahun  {{ $mitra_teladan->year }} & Triwulan {{ $mitra_teladan->quarter }}</p>
    </div>

    <form id="penilaianForm" action="{{ route('penilaian2.update', $nilai_2->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="nilai_2_id" value="{{ $nilai_2->id }}">
        
        <div class="p-6 bg-gray-100 rounded-md shadow-md dark:bg-gray-800">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400 bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">Variabel</th>
                        <th scope="col" class="px-6 py-3 text-center">Sangat Buruk</th>
                        <th scope="col" class="px-6 py-3 text-center">Buruk</th>
                        <th scope="col" class="px-6 py-3 text-center">Cukup</th>
                        <th scope="col" class="px-6 py-3 text-center">Baik</th>
                        <th scope="col" class="px-6 py-3 text-center">Sangat Baik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian2 as $key => $var )
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $var->variabel }}</td>
                            @for($i = 1; $i <= 5; $i++)
                                <td class="px-6 py-4 text-center">
                                    <input type="radio" name="aspek{{$key + 1}}" value="{{ $i }}" 
                                    {{ old("aspek" . ($key + 1), $nilai_2->{'aspek' . ($key + 1)} == $i ? 'checked' : '') }}
                                    class="text-blue-600 form-radio dark:text-blue-400 required">
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button" onclick="window.history.back()" class="px-6 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-600">
                Back
            </button>

             <!-- Submit Button -->
             <button type="button" onclick="confirmSubmission()" class="px-4 py-2 text-white bg-orange-500 border border-transparent rounded-lg shadow-sm accept-btn hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:bg-orange-600 dark:hover:bg-orange-700">
                Kirim
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmSubmission() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to finalize the evaluation?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Yes, confirm!',
            cancelButtonText: 'Cancel',
            html: `
                <label>
                    <input type="checkbox" id="isFinalCheckbox"> Mark as Final
                </label>
            `,
            preConfirm: () => {
                const isFinal = document.getElementById('isFinalCheckbox').checked;
                return { is_final: isFinal ? 1 : 0 };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const isFinalInput = document.createElement('input');
                isFinalInput.type = 'hidden';
                isFinalInput.name = 'is_final';
                isFinalInput.value = result.value.is_final;

                const form = document.getElementById('penilaianForm');
                form.appendChild(isFinalInput);
                
                console.log('is_final:', isFinalInput.value); // Add this to debug
                
                form.submit();
            }
        });
    }
</script>


@endsection
