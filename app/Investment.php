<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['amount_offered'];

    public function getCurrentInvestments(User $user)
    {
        $investments = Investment::where([
            ['user_id', $user->id],
            ['activation', 0],
            ['paid_complete', 0],
            ['completed', 0]
        ])->get();

        return $investments;
    }

    public function getActiveInvestments($user)
    {
        $investments = Investment::where([
            ['user_id', $user->id],
            ['activation', 0],
            ['paid_complete', 1],
            ['completed', 0]
        ])->get();

        return $investments;
    }

    public function getUnmatchedInvestments()
    {
        $investments = Investment::where([
            ['activation', 0],
            ['total_matched', 0]
        ])->get();

        return $investments;
    }

    // public function 
}
