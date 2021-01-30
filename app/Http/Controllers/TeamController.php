<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::select('team_name', 'id as team_id')
                        ->get();

        return response()->json(['data' => $teams]);
    }

    /**
     * Store a newly created team in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::create(['team_name' => $request->team_name]);

        return response()->json([
            'data' => [
                'team_name' => $team->team_name,
                'team_id' => $team->id
            ]
        ]);
    }

    public function rankings()
    {
        $teams = DB::table('teams')
                    ->select(DB::raw('team_name, id as team_id, played, won, drawn, lost, points'))
                    ->orderByDesc('points')
                    ->get();

        $teams = $teams->map(function($team, $index) {
            $team->position = $index + 1;
            
            return $team;
        });

        return response()->json(['data' => $teams]);
    }
}