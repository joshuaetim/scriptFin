<?php

namespace App\Classes;

use App\User;
use DateTime;
use App\Withdraw;
use Carbon\Carbon;
use App\Investment;
use App\Jobs\BlockUser;
use App\Jobs\MatchUsers;

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
        // check if investment is totally matched
        if($investment->total_matched)
        {
            return "You have been completely matched. Check your dashboard for details";
        }

        // get withdraws of unmatched users, in no time
        $unmatchedUsers = User::where([
            ['id', '!=', $user->id]
        ])->pluck('id');
        
        $unmatchedWithdraws = [];
        foreach($unmatchedUsers as $unmatchedUser){
            $withdrawInfo = Withdraw::where([
                ['user_id', $unmatchedUser],
                ['complete_matched', 0]
                ])->get()->first();
            if($withdrawInfo){
                $unmatchedWithdraws[] = $withdrawInfo;
            }
        }
        $unmatchedWithdrawsCollection = collect($unmatchedWithdraws);
        // end get withdraws of unmatched users



        foreach($unmatchedWithdrawsCollection as $withdraw){
            if($investment->amount_offered == $withdraw->amount)
            {
                // match, make withdrawal, bye bye

                $withdrawer = User::find($withdraw->user_id);
                $withdrawer->matched = true;
                $withdrawer->save();
                
                $user->matched = true;
                $user->save();

                $withdrawModel = Withdraw::findOrFail($withdraw->id);
                $withdrawModel->payer = $user->id;
                $withdrawModel->investment = $investment->id;
                $withdrawModel->complete_matched = true;
                $withdrawModel->mature_date = now()->addHours(24);
                $withdrawModel->save();

                // set total matched field for investment

                $amount = getTotalWithdrawAmount($investment);
                if($amount){
                    if($amount == $investment->main_offered)
                    {
                        $investment->total_matched = true;
                        $investment->save();
                    }
                }

                // blocking section
                
                // refresh withdraw model and user, for blocking

                $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
                $newUserModel = User::findOrFail($user->id);
                $date = Carbon::create($newWithdrawModel->mature_date);

                $time = now()->addHours(24);
                BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

                return 'You have been successfully matched with '. $withdrawer->name;

                // end blocking section

            } // if withrawer not matched, check equality and match
        }

        // return $unmatchedWithdrawsCollection;

        if($unmatchedWithdrawsCollection->count()){
            $randomWithdraw = $unmatchedWithdrawsCollection->random();
        }
        else{
            $time = Carbon::now()->addUnitNoOverflow('hour', 24, 'day');
            MatchUsers::dispatch($user, $investment)->delay($time);
            return 'No users left. Please wait for next day matching.';
        }

        if($randomWithdraw->amount > $investment->amount_offered)
        {
            /**
            * investor cleared, multiple withdrawals
            */
            // match them, call multipleMatchWithdrawal

            $difference = $randomWithdraw->amount - $investment->amount_offered;

            $withdrawer = User::find($randomWithdraw->user_id);
            $withdrawer->matched = true;
            $withdrawer->multiple_matched++;
            $withdrawer->save();

            $user->matched = true;
            $user->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->amount = $investment->amount_offered;
            $withdrawModel->payer = $user->id;
            $withdrawModel->investment = $investment->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            // set total matched field for investment

            $amount = getTotalWithdrawAmount($investment);
            if($amount){
                if($amount == $investment->main_offered)
                {
                    $investment->total_matched = true;
                    $investment->save();
                }
            }

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            $time = now()->addHours(24);
            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            return $this->createNewWithdrawsRecord($difference, $withdrawer);
        }

        elseif($randomWithdraw->amount < $investment->amount_offered)
        {
            /**
            * withdrawer cleared, multiple investment
            */
            $difference = $investment->amount_offered - $randomWithdraw->amount;
            
            // match them, call multipleMatchInvestment
            $withdrawer = User::find($randomWithdraw->user_id);
            $withdrawer->matched = true;
            $withdrawer->save();
            
            $user->matched = true;
            $user->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->payer = $user->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->investment = $investment->id;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            // set total matched field for investment

            $amount = getTotalWithdrawAmount($investment);
            if($amount){
                if($amount == $investment->main_offered)
                {
                    $investment->total_matched = true;
                    $investment->save();
                }
            }

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            $time = now()->addHours(24);
            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            return $this->multipleMatchInvestment($difference, $user, $investment);
        }
    }

    public function multipleMatchInvestment($difference, $user, $investment)
    {
        /**
         * receiver has been fully matched. We want someone to match investor with, again
         * look for unmatched users, and get their withdraws
         * 
         * difference = excess amount for investor to invest
         * 
         * if difference = withdraw amount, match users, make withdraw and close chapter
         * 
         * if differnce is less than withdraw amount, still make withdrawal, and call multiple withdrawals
         * 
         * if difference is greater, still make withdrawal, and call multiple investments
        */ 

        // get withdraws of unmatched users, in no time
        $unmatchedUsers = User::where([
            ['id', '!=', $user->id]
        ])->pluck('id');
       
       $unmatchedWithdraws = [];
       foreach($unmatchedUsers as $unmatchedUser){
           $withdrawInfo = Withdraw::where([
               ['user_id', $unmatchedUser],
               ['complete_matched', 0]
               ])->get()->first();
           if($withdrawInfo){
               $unmatchedWithdraws[] = $withdrawInfo;
           }
       }
       $unmatchedWithdrawsCollection = collect($unmatchedWithdraws);
       // end get withdraws of unmatched users

        foreach($unmatchedWithdrawsCollection as $withdraw){ // if equal
            if($difference == $withdraw->amount)
            {
                $user->multiple_matched++;
                $user->save();

                $withdrawer = User::findOrFail($withdraw->user_id);
                $withdrawer->matched = true;
                $withdrawer->save();

                $withdrawModel = Withdraw::findOrFail($withdraw->id);
                $withdrawModel->payer = $user->id;
                $withdrawModel->complete_matched = true;
                $withdrawModel->investment = $investment->id;
                $withdrawModel->mature_date = now()->addHours(24);
                $withdrawModel->save();

                // set total matched field for investment

                $amount = getTotalWithdrawAmount($investment);
                if($amount){
                    if($amount == $investment->main_offered)
                    {
                        $investment->total_matched = true;
                        $investment->save();
                    }
                }

                // blocking section
                
                // refresh withdraw model and user, for blocking

                $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
                $newUserModel = User::findOrFail($user->id);
                $date = Carbon::create($newWithdrawModel->mature_date);

                $time = now()->addHours(24);
                BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

                // dd('You have been successfully matched with '. $withdrawer->name);

                // end blocking section

                return "You have been merged. Check your dashboard for details";
            } // if difference checks out, make some database changes
        }

        if($unmatchedWithdrawsCollection->count()){
            $randomWithdraw = $unmatchedWithdrawsCollection->random();
        }
        else{
            // update investment field, schedule next day matching, starting from scratch
            $getInvestment = Investment::findOrFail($investment->id);
            $getInvestment->amount_offered = $difference;
            $getInvestment->save();

            $time = Carbon::now()->addUnitNoOverflow('hour', 24, 'day');
            MatchUsers::dispatch($user, $getInvestment)->delay($time);
            return "You have been merged. Check your dashboard for details";
        }

        if($difference < $randomWithdraw->amount) // less than, investor is cleared
        {
            // dd($difference);
            $user->multiple_matched++;
            $user->save();

            $withdrawer = User::findOrFail($randomWithdraw->user_id);
            $withdrawer->matched = true;
            $withdrawer->multiple_matched++;
            $withdrawer->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->amount = $difference;
            $withdrawModel->payer = $user->id;
            $withdrawModel->investment = $investment->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            $difference = $randomWithdraw->amount - $difference;

            // set total matched field for investment

            $amount = getTotalWithdrawAmount($investment);
            if($amount){
                if($amount == $investment->main_offered)
                {
                    $investment->total_matched = true;
                    $investment->save();
                }
            }

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            $time = now()->addHours(24);
            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            return $this->createNewWithdrawsRecord($difference, $withdrawer);

        }

        if($difference > $randomWithdraw->amount) // greater than, withdrawer is cleared
        {
            $user->multiple_matched++;
            $user->save();

            $withdrawer = User::findOrFail($randomWithdraw->user_id);
            $withdrawer->matched = true;
            $withdrawer->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->payer = $user->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->investment = $investment->id;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            // set total matched field for investment

            $amount = getTotalWithdrawAmount($investment);
            if($amount){
                if($amount == $investment->main_offered)
                {
                    $investment->total_matched = true;
                    $investment->save();
                }
            }

            $difference = $difference - $randomWithdraw->amount;

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            $time = now()->addHours(24);
            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($time);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            return $this->multipleMatchInvestment($difference, $user, $investment);
        }


    }

    public function createNewWithdrawsRecord($difference, $withdrawer)
    {
        $withdraw = new Withdraw;
        $withdraw->user_id = $withdrawer->id;
        $withdraw->amount = $difference;
        $withdraw->created_at = new DateTime;
        $withdraw->save();

        return "You have been merged. Check your dashboard for details";
    }

    public function manualMatching($investment, $withdraw)
    {
        $investment = Investment::findOrFail($investment);
        $withdraw = Withdraw::findOrFail($withdraw);
        // merge single users, update models

        if(! $withdraw->complete_matched) // if the withdraw has not been matched
        {
            // update withdraw model

            $withdraw->payer = getUser($investment->user_id)->id;
            $withdraw->investment = $investment->id;
            $withdraw->amount = $investment->amount_offered;
            $withdraw->complete_matched = true;
            $withdraw->mature_date = now()->addHours(24);
            $withdraw->save();

            // update investment model
        }

        else{
            // create new WithDraw Model for it

            $withdrawModel = new Withdraw;
            $withdrawModel->user_id = getUser($withdraw->user_id)->id;
            $withdrawModel->payer = getUser($investment->user_id)->id;
            $withdrawModel->investment = $investment->id;
            $withdrawModel->amount = $investment->amount_offered;
            $withdrawModel->complete_matched = true;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();
        }


        // set total matched if user finish matching 

        $amount = getTotalWithdrawAmount($investment);
        if($amount){
            if($amount == $investment->main_offered)
            {
                $investment->total_matched = true;
                $investment->save();
            }
        }

        // match users

        $withdrawer = User::find($withdraw->user_id);
        if($withdrawer->matched)
        {
            $withdrawer->multiple_matched++;
            $withdrawer->save();
        }
        else{
            $withdrawer->matched = true;
            $withdrawer->save();
        }

        $investor = User::find($investment->user_id);
        if($investor->matched)
        {
            $investor->multiple_matched++;
            $investor->save();
        }
        else{
            $investor->matched = true;
            $investor->save();
        }

        // end user matching

        // end match single user
    }
}