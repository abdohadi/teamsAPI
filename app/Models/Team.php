<?php

namespace App\Models;

use App\Models\Match;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['team_name'];

    public function matches()
    {
    	return $this->belongsToMany(Match::class)->withPivot('team_score');
    }
}
