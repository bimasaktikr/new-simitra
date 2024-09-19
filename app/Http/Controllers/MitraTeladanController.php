<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mitra;
use App\Models\MitraTeladan;
use App\Models\Survey;
use App\Models\Nilai;
use App\Models\Team;
use App\Services\MitraService;
use Carbon\Carbon;
use Psy\Readline\Hoa\Console;

use function Laravel\Prompts\alert;

class MitraTeladanController extends Controller
{
    protected $user;
    protected $mitra;
    protected $mitraService;


    public function __construct(MitraService $mitraService)
    {
        $this->user = Auth::user();
        $this->mitraService = $mitraService;
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
                        ->get()
                        ->toArray();
        // Adding the 'status' attribute to each item
        foreach ($mitrateladan as &$item) {
            $item['status'] = 'final'; // Replace 'some status' with the desired status value
        }

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

        $groupedByTeam = array_merge($groupedByTeam, $mitrateladan);

        // dd($groupedByTeam);
        return view('mitrateladan', compact('groupedByTeam', 'year', 'quarter'));
        
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
                'avg_rating'    => (float)$validatedData['rating'],     // Ensure rating is a float
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

}
