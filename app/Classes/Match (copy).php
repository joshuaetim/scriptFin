<?php

namespace App\Classes;

use App\User;
use Carbon\Carbon;
use App\Investment;
use App\Jobs\BlockUser;

class Match
{
    public function matchToSuperAdmin()
    {
        $otherUsers = User::where([
            ['special', 1],
            ['level', 10],
        ])->get();

        if($otherUsers->count() == 0)
        {
            return false;
        }

        $selectedUser = $otherUsers->random();
        $selectedUser->save();

        return $selectedUser;
    }

    /**
     * Normal matching for normal users, active, unblocked and unmatched
     */
    public function matchUsersNormally(Investment $investment, User $user)
    {
        // get active withdraw requests

        $withdraws = Withdraw::all();

        // $users = User::where([
        //     ['active', 1],
        //     ['level', '>', 1],
        //     ['matched', 0],
        //     ['blocked', 0],
        //     ['id', '!=', $user->id] // we don't want the same user to match to itself
        // ])->get();

        if($users->count())
        {
            $selectedUser = $users->random();

            $investment->receiver = $selectedUser->id;

            $investment->mature_date = now()->addHours(24);
            $investment->save();

            $userObject = new User;

            $userObject->setMatched($selectedUser->id);

            $userObject->setMatched($user->id);

            // Refresh models, schedule blocking
             
            $investment = Investment::find($investment->id);
            $user = User::find($user->id);
            
            $date = Carbon::create($investment->mature_date);
            
            BlockUser::dispatch($user, $investment)->delay($date);

            return 'You have been successfully matched with '. $selectedUser->name;
        }
        else{
            // change time to normal 1 day hour overflow

            $time = Carbon::now()->addMinutes(1);

            MatchUsers::dispatch($user, $investment)->delay($time);

            return 'No user had the requirements for matching yet';
        }
    }
}