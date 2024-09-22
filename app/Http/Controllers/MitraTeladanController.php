<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Survey;
use App\Models\Nilai;
use App\Models\Nilai2;
use App\Models\Team;
use App\Services\MitraService;
use App\Services\Nilai2Service;
use Carbon\Carbon;
use Psy\Readline\Hoa\Console;

use function Laravel\Prompts\alert;

class MitraTeladanController extends Controller
{
    protected $user;
    protected $mitra;
    protected $mitraService;
    protected $nilai2Service;



    public function __construct(MitraService $mitraService, Nilai2Service $nilai2Service)
    {
        $this->user = Auth::user();
        $this->mitraService = $mitraService;
        $this->nilai2Service = $nilai2Service;
    }

    public function index(Request $request)
    {
        // $perPage = $request->input('per_page', 10);
        $year = $request->input('year');
        $quarter = $request->input('quarter');
        
        $groupedByTeam = [];
        $mitra_teladan = [];
        $mitra_teladan_check = $this->mitraService->checkMitraTeladan($year,$quarter);
        
        $mitra_teladan_empty = $mitra_teladan_check['mitra_teladan_empty'];
        $mitra_teladan_choosed = $mitra_teladan_check['mitra_teladan'];
        
        $mitrateladan = MitraTeladan::where('year', $year)
                        ->where('quarter', $quarter)
                        ->with('mitra:id_sobat,name')
                        ->get()
                        ->toArray();

       
            
            // Adding the 'status' attribute to each item
        foreach ($mitrateladan as &$item) {
            $item['status'] = 'final';

            $nilai_2_average = $this->nilai2Service->getAverageRating($item['id']); 
            $item['nilai_2'] = $nilai_2_average;

            $nilai_2_final = $this->nilai2Service->getStatus($item['id']);
            // dd( $nilai_2_final);
            $item['is_final'] = $nilai_2_final;

            $team_done = $this->nilai2Service->getTeamDone($item['id']);
            $item['team_done'] = $team_done;
            
            $is_all_final = $this->nilai2Service->checkFinal($item['id']);
            $item['is_all_final'] = $is_all_final;
        }

        // dd($mitrateladan);

        foreach ($mitra_teladan_empty as $team_id) {
            // alert($team_id);
            // Call the service method with the team_id
            $result = $this->mitraService->getTopMitra($year, $quarter, $team_id);

            // dd($result);
            // Optionally decode the result if it's JSON
            $result = json_decode($result, true);
            
            // Combine the results (assuming you want to aggregate them)
            $groupedByTeam = array_merge($groupedByTeam, $result);
        }

        $winnerTeam = $this->mitraService->getWinnerTeam($year, $quarter);
        // dd($groupedByTeam);

        $groupedByTeam = array_merge($groupedByTeam, $mitrateladan);
        // dd($groupedByTeam);

        return view('mitrateladan.index', compact('groupedByTeam', 'year', 'quarter', 'winnerTeam'));
    }

    // In your Controller
    public function storeMitraTeladan(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'mitra_id' => 'required',
                'rating' => 'required',
                'survey_count' => 'required',
                'team_id' => 'required',
                'year' => 'required',
                'quarter' => 'required',
            ]);

             // Check if a Mitra Teladan already exists for this team, year, and quarter
            $existingMitra = MitraTeladan::where('team_id', $validatedData['team_id'])
                                ->where('year', (int)$validatedData['year'])
                                ->where('quarter', (int)$validatedData['quarter'])
                                ->first();
            
            if ($existingMitra) {
                // If an entry already exists, return an error response
                return response()->json([
                    'success' => false,
                    'message' => 'A Mitra Teladan already exists for this team, year, and quarter.'
                ], 409); // HTTP 409 Conflict
            }

            // Save to the mitra_teladan table
            MitraTeladan::firstOrCreate([
                'mitra_id'      => $validatedData['mitra_id'],
                'team_id'       => $validatedData['team_id'],
                'year'          => (int)$validatedData['year'],         // Ensure year is an integer
                'quarter'       => (int)$validatedData['quarter'],      // Ensure quarter is an integer
                'avg_rating_1'    => (float)$validatedData['rating'],     // Ensure rating is a float
                'surveys_count' => (int)$validatedData['survey_count'], // Ensure survey_count is an integer
            ]);

            // Return a success response
            return response()->json([
                'success' => true, 
                'message' => 'Mitra Teladan data saved successfully'
            ], 200);
        
        } catch (\Exception $e) {
            // If an error occurs, return a JSON error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Mitra Teladan data',
                'error' => $e->getMessage()  // Optional: for debugging purposes, you might want to include the error message
            ], 500);
        }
    }

    public function setFinal($mitra_teladan_id)
    {
        // Use the service to set the final status
        $mitraTeladan = $this->mitraService->setFinal($mitra_teladan_id);

        // Optionally, add some feedback for the user
        if ($mitraTeladan->status_phase_2) {
            
            return redirect()->back()->with('success', 'Status Phase 2 has been finalized successfully.');
        }

        return redirect()->back()->with('error', 'Unable to finalize. Some ratings are still not final.');
    }

}
