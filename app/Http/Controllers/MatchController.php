<?php

namespace App\Http\Controllers;

use App\Models\Team;
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
        $idRules = 'required|integer|numeric|min:1';
        $scoreRules = 'required|integer|numeric|min:0';
        $request->validate([
            'team_a_id' => $idRules,
            'team_b_id' => $idRules,
            'team_a_score' => $scoreRules,
            'team_b_score' => $scoreRules,
        ]);

        if (! Team::find($request->team_a_id))
            return $this->teamNotFound($request->team_a_id);
        if (! Team::find($request->team_b_id))
            return $this->teamNotFound($request->team_b_id);

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

    protected function teamNotFound($id)
    {
        return response()->json(["error" => "A team with an id of '" .$id. "' not found."], 422);
    }
}
