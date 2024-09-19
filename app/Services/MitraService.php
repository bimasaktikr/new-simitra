<?php
// app/Services/EmployeeSelectionService.php
namespace App\Services;

use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Team;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MitraService
{
        
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
}
