<?php
// app/Services/EmployeeSelectionService.php
namespace App\Services;

use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Nilai1;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class MitraService
{   
    protected $nilai2Service;



    public function __construct(Nilai2Service $nilai2Service)
    {
        $this->nilai2Service = $nilai2Service;
    }
        
    public function getTopMitra($year=null, $quarter=null, $team_id)
    {   
        if ($year && $quarter)
        {
            $startDate = $this->getQuarterStartDate($year,$quarter);
            $endDate = $this->getQuarterEndDate($year,$quarter);
        } else {
            $startDate = $this->getQuarterStartDate($year,1);
            $endDate = $this->getQuarterEndDate($year,4);
        }
        
        // $mitraSummary = $this->getMitraSummary($startDate, $endDate);
        $mitraSummary = $this->getMitraSummary($startDate, $endDate, $team_id);
        
        // dd($mitraSummary->toSql(), $mitraSummary->getBindings());
        // dd($mitraSummary->toSql());
        
        $rankedMitra = $this->getRankedMitra($mitraSummary);
        // dd($rankedMitra->toSql());
        //  dd($rankedMitra->toSql(), $rankedMitra->getBindings());

        $finalMitraResult = $this->getFinalMitraResult($rankedMitra, $startDate, $endDate, $team_id);
        // dd($finalMitraResult);

        // $groupedByTeam = $finalMitraResult->groupBy('team_id');
        $groupedByTeam = $finalMitraResult;
        // dd($groupedByTeam);
        return $groupedByTeam;
    }

    /**
     * Check Mitra Teladan on Year & Quarter
     */
    public function checkMitraTeladan($year,$quarter)
    {
        $team = Team::all()->count();

        $mitra_teladan_empty = [];
        $mitra_teladan = [];
        // Loop through team_id from 1 to 5 
        for ($i = 1; $i <= $team; $i++) 
        {
            // Query to check if there are any entries for the given team_id
            $mitrateladan = MitraTeladan::where('year', $year)
                                        ->where('quarter', $quarter)
                                        ->where('team_id', $i)
                                        ->exists();

            // If entries exist, push the team_id into the array
            if (!$mitrateladan) {
                $mitra_teladan_empty[] = $i;
            } else {
                $mitra_teladan[]= $i;
            }
        }

        return [
            'mitra_teladan_empty' => $mitra_teladan_empty,
            'mitra_teladan' => $mitra_teladan
        ];
    }
    
    /**
     * Get mitra summary (distinct survey count, average rerata, etc.)
     */
    private function getMitraSummary($startDate, $endDate, $team_id)
    {   
        return DB::table('transactions as t')
                    ->join('surveys as s', 't.survey_id', '=', 's.id')
                    ->join('nilai1 as n', 't.id', '=', 'n.transaction_id')
                    ->select(
                        't.mitra_id',
                        DB::raw('COUNT(DISTINCT s.id) as distinct_survey_count'),
                        DB::raw('AVG(n.rerata) as average_rerata'),
                        's.team_id'
                    )
                    ->whereBetween('s.end_date', [$startDate, $endDate])
                    ->where('s.team_id', $team_id)
                    ->groupBy('t.mitra_id', 's.team_id');
    }

    /**
     * Rank mitra by average rerata within each team
     */
    private function getRankedMitra($mitraSummary)
    {
        return DB::table(DB::raw("({$mitraSummary->toSql()}) as ms"))
            ->mergeBindings($mitraSummary)
            ->select(
                'ms.mitra_id',
                'ms.distinct_survey_count',
                'ms.average_rerata',
                'ms.team_id',
                DB::raw('RANK() OVER (PARTITION BY ms.team_id ORDER BY ms.average_rerata DESC, ms.distinct_survey_count DESC) as rnk')
                // DB::raw('RANK() PARTITION BY ms.team_id ORDER BY ms.average_rerata DESC as rnk')
            );
    }

    /**
     * Get the final result for top mitra within the given date range
     */
    private function getFinalMitraResult($rankedMitra)
    {
        return DB::table(DB::raw("({$rankedMitra->toSql()}) as rm"))
            ->mergeBindings($rankedMitra)
            ->join('mitras as m', 'rm.mitra_id', '=', 'm.id_sobat')
            ->select(
                'm.id_sobat as mitra_id',
                'm.name as mitra_name',
                'rm.average_rerata',
                'rm.distinct_survey_count',
                'rm.team_id',
                'rm.rnk'
            )
            ->where('rm.rnk', 1)
            ->groupBy('m.id_sobat', 'm.name', 'rm.average_rerata', 'rm.distinct_survey_count', 'rm.team_id')
            ->get();
    }

    /**
     * Get the start date of a specific quarter in a year.
     *
     * @param int $year
     * @param int $quarter
     * @return Carbon
     */
    private function getQuarterStartDate($year, $quarter)
    {
        switch ($quarter) {
            case 1:
                return Carbon::create($year, 1, 1)->startOfDay();
            case 2:
                return Carbon::create($year, 4, 1)->startOfDay();
            case 3:
                return Carbon::create($year, 7, 1)->startOfDay();
            case 4:
                return Carbon::create($year, 10, 1)->startOfDay();
            default:
                throw new \InvalidArgumentException("Invalid quarter: $quarter");
        }
    }

    /**
     * Get the end date of a specific quarter in a year.
     *
     * @param int $year
     * @param int $quarter
     * @return Carbon
     */
    private function getQuarterEndDate($year, $quarter)
    {
        switch ($quarter) {
            case 1:
                return Carbon::create($year, 3, 31)->endOfDay();
            case 2:
                return Carbon::create($year, 6, 30)->endOfDay();
            case 3:
                return Carbon::create($year, 9, 30)->endOfDay();
            case 4:
                return Carbon::create($year, 12, 31)->endOfDay();
            default:
                throw new \InvalidArgumentException("Invalid quarter: $quarter");
        }
    }


    public function setFinal($id)
    {
        // Find the MitraTeladan by its ID
        $mitraTeladan = MitraTeladan::findOrFail($id);
    
        $mitraTeladan->update(['status_phase_2' => true]);
        
        // Calculate the average nilai_2 and update avg_rating_2
        $nilai_2_average = $this->nilai2Service->getAverageRating($id);

        // Update avg_rating_2 in the mitraTeladan record
        $mitraTeladan->update(['avg_rating_2' => $nilai_2_average]);
        // dd($mitraTeladan);
        return $mitraTeladan;
    }

    public function getStatusPhase2($id)
    {
        // Find the MitraTeladan by ID and get the status_phase_2 value
        $status = MitraTeladan::where('id', $id)->value('status_phase_2');

        // Return true if status_phase_2 is 1 (or true), otherwise false
        return (bool) $status;
    }

    public function getWinnerTeam($year, $quarter)
    {
        $winnerTeam = MitraTeladan::where('year', $year)
                                    ->where('quarter', $quarter)
                                    ->whereNotNull('avg_rating_2')
                                    ->orderBy('avg_rating_2', 'desc')
                                    ->first();
        if($winnerTeam)
        {
            return $winnerTeam->team_id;
        } else{
            return null;
        }
    }
   
    public function importMitra($filterData, $survey)
    {   
        $dataWithoutHeader = array_slice($filterData[0], 1);
        // dd($dataWithoutHeader);
        // dd($dataWithoutHeader);
        // Iterasi setiap baris dalam file Excel
        foreach ($dataWithoutHeader as $row) {
            $dateObject = DateTime::createFromFormat('d/m/Y', $row[5]);
            $formattedDate = $dateObject->format('Y-m-d');
            
            $id_mitra = $row[0];
            $name = $row[1];
            $jenis_kelamin = $row[2];
            $email = $row[3];
            $pendidikan = $row[4];
            $tanggal_lahir = $formattedDate;
            $aspek1 = is_numeric($row[6]) ? (float)$row[6] : 0;
            $aspek2 = is_numeric($row[7]) ? (float)$row[7] : 0;
            $aspek3 = is_numeric($row[8]) ? (float)$row[8] : 0;
            $rerata = ($aspek1 + $aspek2 + $aspek3) / 3;

            // dd($row);

            $user = User::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'password' => bcrypt('malangkota3573'), 
                'role_id' => 5,
                'status' => 'Aktif',
            ]);

            $mitra = Mitra::firstOrCreate(
                [
                    'id_sobat' => $id_mitra
                ], 
                [
                    'name' => $name,
                    'email' => $email,
                    'user_id' => $user->id,
                    'jenis_kelamin' => $jenis_kelamin, 
                    'pendidikan' => $pendidikan,
                    'tanggal_lahir' => $tanggal_lahir
            ]);

            // Tambahkan transaksi
            $transaction = Transaction::create([
                'survey_id' => $survey->id,
                'mitra_id' => $mitra->id_sobat,
                'payment' => $survey->payment,
                'target' => $target ?? 1,
            ]);

           Nilai1::create([
                'transaction_id'    => $transaction->id,
                'aspek1'            => $aspek1,
                'aspek2'            => $aspek2,
                'aspek3'            => $aspek3,
                'rerata'            => $rerata, // Assign each transaction its own Nilai1
            ]);
            
        }

        return true;
    }



}
