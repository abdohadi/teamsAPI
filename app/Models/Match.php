<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Match extends Model
{
    use HasFactory;

    public function teams()
    {
    	return $this->belongsToMany(Team::class)->withPivot('team_score');
    }

    public function updateTeams()
    {
    	list($team_a, $team_b) = $this->teams;
    	
        $team_a->fill(['played' => $team_a->played++]);
        $team_b->fill(['played' => $team_b->played++]);
        
    	if ($team_a->pivot->team_score > $team_b->pivot->team_score) {
    		$team_a->update([
    			'points' => $team_a->points += 3,
    			'won' => $team_a->won += 1
    		]);

    		$team_b->update([
    			'lost' => $team_b->lost += 1
    		]);
    	} elseif ($team_a->pivot->team_score < $team_b->pivot->team_score) {
    		$team_a->update([
    			'lost' => $team_a->lost += 1
    		]);

    		$team_b->update([
    			'points' => $team_b->points += 3,
    			'won' => $team_b->won += 1
    		]);
    	} else {
    		$team_a->update([
    			'points' => $team_a->points += 1,
    			'drawn' => $team_a->drawn += 1
    		]);

    		$team_b->update([
    			'points' => $team_b->points += 1,
    			'drawn' => $team_b->drawn += 1
    		]);
    	}
    }
}
