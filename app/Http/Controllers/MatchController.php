<?php

namespace App\Http\Controllers;

use App\Models\Match;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Store a newly created match in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request

        // New match
        $match = Match::create();
        $match->teams()->attach([
            $request->team_a_id => ['team_score' => $request->team_a_score],
            $request->team_b_id => ['team_score' => $request->team_b_score]
        ]);

        // Update teams' scores
        $match->updateTeams();

        return response()->json(['data' => $match]);
    }
}