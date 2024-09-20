<?php
// app/Services/EmployeeSelectionService.php
namespace App\Services;

use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Nilai2;
use App\Models\Team;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Nilai2Service
{
    /**
     * Save a new Nilai2 record.
     *
     * @param array $data
     * @return bool
     */
    public function saveNilai2(array $data)
    {
        try {
            DB::beginTransaction();
            
            Nilai2::create($data);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error saving Nilai2: ' . $th->getMessage(), ['exception' => $th]);
            return false;
        }
    }

    public function getAverageRating($id)
    {
        return Nilai2::where('mitra_teladan_id', $id)
                        ->avg('rerata');
    }

    public function getTeamDone($id)
    {
        return Nilai2::where('mitra_teladan_id', $id)
                        ->pluck('team_penilai_id');
    }
    
}
