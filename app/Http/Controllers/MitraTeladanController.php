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
        $mitra_teladan_check = $this->mitraService->checkMitraTeladan($year,$quarter);
        
        $mitra_teladan_empty = $mitra_teladan_check['mitra_teladan_empty'];
        $mitra_teladan = $mitra_teladan_check['mitra_teladan'];
        
        if(empty($mitra_teladan_empty))
        {   
            $mitrateladan = MitraTeladan::where('year', $year)
                                        ->where('quarter', $quarter)
                                        ->get();
            $groupedByTeam  = $mitrateladan;
            return view('mitrateladan', compact('groupedByTeam ', 'year', 'quarter'));
        } else {
            /**
             *  Jika Ada Tim Yang kosong, maka akan dilakukan generate data
             *  dari database.
             */
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
            // dd($groupedByTeam);
            return view('mitrateladan', compact('groupedByTeam', 'year', 'quarter'));
        }
    }

    // In your Controller
    public function storeMitraTeladan(Request $request)
    {
        $validatedData = $request->validate([
            'mitra_id' => 'required',
            'rating' => 'required',
            'survey_count' => 'required',
            'team_id' => 'required',
            'year' => 'required',
            'quarter' => 'required',
        ]);

        // dd($validated);
        // Save to the mitra_teladan table
        MitraTeladan::create([
            'mitra_id'      => $validatedData['mitra_id'],
            'team_id'       => $validatedData['team_id'],
            'year'          => (int)$validatedData['year'],         // Ensure year is an integer
            'quarter'       => (int)$validatedData['quarter'],      // Ensure quarter is an integer
            'avg_rating'    => (float)$validatedData['rating'],     // Ensure rating is a float
            'surveys_count' => (int)$validatedData['survey_count'], // Ensure survey_count is an integer
        ]);
    
        // Step 3: Return a response (you can adjust this as needed)
        return response()->json(['message' => 'Mitra Teladan data saved successfully'], 200);
    }
}
