<?php
// app/Services/EmployeeSelectionService.php
namespace App\Services;

use App\Models\Mitra;
use Illuminate\Support\Carbon;

class MitraService
{
    /**
     * Get the best employee (Mitra) for a specific year and quarter.
     *
     * @param int $year
     * @param int $quarter (values 1-4)
     * @return Employee|null
     */
    public function getAllMitra($year, $quarter)
    {   
        // Determine the start and end dates for the given quarter.
        $startDate = $this->getQuarterStartDate($year, $quarter);
        $endDate = $this->getQuarterEndDate($year, $quarter);

        // Query employees with performance data in the specified date range.
        // return $mitras = Mitra::whereHas('surveys', function ($query) use ($startDate, $endDate) {
        //                         $query->whereBetween('start_date', [$startDate, $endDate]);
        //                     })->get();

        // Query employees with performance data in the specified date range.
        return $mitraData = Mitra::with(['transactions.survey', 'transactions.nilai1'])
                            ->get()
                            ->map(function($mitra) {
                                $mitra->average_score = $mitra->transactions->flatMap(function($transaction) {
                                    return $transaction->nilai1;
                                })->avg('rerata');
                                
                                // Assuming 'survey_name' is required from the first transaction's survey
                                $mitra->survey_name = $mitra->transactions->first()->survey->survey_name ?? null;
                                
                                return $mitra;
                            });

        // dd($mitras->toSql());
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
