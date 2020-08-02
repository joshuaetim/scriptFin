<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use App\Admin;
use App\Support;
use App\Withdraw;
use Carbon\Carbon;
use App\Investment;
use App\PaymentLog;
use App\Classes\Match;
use App\Jobs\BlockUser;
use App\Jobs\MatchUsers;
use App\Mail\Registered;
use App\Classes\Receiver;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Jobs\CreateSpecialUser;
use App\Jobs\DeleteInactiveUsers;
use App\Notifications\MatchResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PlayController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function trap(Request $request)
    {
        return $request->all();
    }

    public function play()
    {
        $investment = Investment::find(3);
        if($investment->mature_date > now()){
            return 'Not mature';
        }
        else{
            return 'Mature';
        }
    }


    public function meme()
    {

        $user = User::find(6);
        $investment = Investment::find(4); // investor




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
                $withdrawModel->complete_matched = true;
                $withdrawModel->mature_date = now()->addHours(24);
                $withdrawModel->save();

                // blocking section
                
                // refresh withdraw model and user, for blocking

                $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
                $newUserModel = User::findOrFail($user->id);
                $date = Carbon::create($newWithdrawModel->mature_date);

                BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

                dd('You have been successfully matched with '. $withdrawer->name);

                // end blocking section

            } // if withrawer not matched, check equality and match
        }

        // return $unmatchedWithdrawsCollection;

        if($unmatchedWithdrawsCollection->count()){
            $randomWithdraw = $unmatchedWithdrawsCollection->random();
        }
        else{
            dd("No users left. Please wait for next day matching.");
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
            $withdrawer->save();

            $user->matched = true;
            $user->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->amount = $investment->amount_offered;
            $withdrawModel->payer = $user->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            $this->createNewWithdrawsRecord($difference, $withdrawer);
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
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            $this->multipleMatchInvestment($difference, $user, $investment);
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
                $withdrawModel->mature_date = now()->addHours(24);
                $withdrawModel->save();

                // blocking section
                
                // refresh withdraw model and user, for blocking

                $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
                $newUserModel = User::findOrFail($user->id);
                $date = Carbon::create($newWithdrawModel->mature_date);

                BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

                // dd('You have been successfully matched with '. $withdrawer->name);

                // end blocking section

                dd("Found perfect match. Ending merging...");
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
            dd("No users left. Investment altered, next day matching scheduled");
        }

        if($difference < $randomWithdraw->amount) // less than, investor is cleared
        {
            // dd($difference);
            $user->multiple_matched++;
            $user->save();

            $withdrawer = User::findOrFail($randomWithdraw->user_id);
            $withdrawer->matched = true;
            $withdrawer->save();

            $withdrawModel = Withdraw::findOrFail($randomWithdraw->id);
            $withdrawModel->amount = $difference;
            $withdrawModel->payer = $user->id;
            $withdrawModel->complete_matched = true;
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            $difference = $randomWithdraw->amount - $difference;

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            $this->createNewWithdrawsRecord($difference, $withdrawer);

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
            $withdrawModel->mature_date = now()->addHours(24);
            $withdrawModel->save();

            $difference = $difference - $randomWithdraw->amount;

            // blocking section
                
            // refresh withdraw model and user, for blocking

            $newWithdrawModel = Withdraw::findOrFail($withdraw->id);
            $newUserModel = User::findOrFail($user->id);
            $date = Carbon::create($newWithdrawModel->mature_date);

            BlockUser::dispatch($newUserModel, $newWithdrawModel)->delay($date);

            // dd('You have been successfully matched with '. $withdrawer->name);

            // end blocking section

            $this->multipleMatchInvestment($difference, $user, $investment);
        }


    }

    public function createNewWithdrawsRecord($difference, $withdrawer)
    {
        $withdraw = new Withdraw;
        $withdraw->user_id = $withdrawer->id;
        $withdraw->amount = $difference;
        $withdraw->created_at = new DateTime;
        $withdraw->save();

        dd("New Withdraw record created, waiting for matching");
    }

    public function multipleMatchWithdrawal($difference, $withdrawer)
    {
        /**
         * investor has been fully matched. We want someone to match withdrawer with, again
         * look for unmatched users, and get their investments
         * if offering equal difference, match them, create new withdrawal and close the chapter
         * 
         * If offering is lower than the remaining difference, match them, make a withdrawal anyway, and do another multiple match withdrawal, passing difference and withdrawer as variables
         * 
         * If offering is greater than remaining difference, match them, make a withdrawal, and call for a multiple matching investment 
        */ 

        // get investments of unmatched users, in no time
        $unmatchedUsers = User::where([
            ['matched', 0]
        ])->pluck('id');
        
        $unmatchedInvestments = [];
        foreach($unmatchedUsers as $unmatchedUser){
            $investmentInfo = Investment::where([
                ['user_id', $unmatchedUser],
                ['activation', 0],
                ['paid', 0],
                ['paid_complete', 0]
                ])->get()->first();

            if($investmentInfo){
                $unmatchedInvestments[] = $investmentInfo;
            }
        }

        $unmatchedInvestmentsCollection = collect($unmatchedInvestments);
        // end get withdraws of unmatched users

        foreach($unmatchedInvestmentsCollection as $investment){
            if($difference == $investment->amount_offered)
            {
                $withdrawer->multiple_matched++;
                $withdrawer->save();

                $withdrawModel = new Withdraw;
                $withdrawModel->user_id = $withdrawer->id;
                $withdrawModel->payer = $investment->user_id;
                $withdrawModel->amount = $difference;
                $withdrawModel->save();

                $investor = User::findOrFail($investment->user_id);
                $investor->matched = true;
                $investor->save();

                return 'Yeah';
            } // if difference checks out, make some database changes
        }

        $randomInvestment = $unmatchedInvestmentsCollection->random();

        if($randomInvestment->amount_offered < $difference) // lower than, investor is cleared
        { 
            $withdrawer->multiple_matched++;
            $withdrawer->save();

            $withdrawModel = new Withdraw;
            $withdrawModel->user_id = $withdrawer->id;
            $withdrawModel->payer = $randomInvestment->user_id;
            $withdrawModel->amount = $difference;
            $withdrawModel->save();

            $investor = User::findOrFail($randomInvestment->user_id);
            $investor->matched = true;
            $investor->save();

            $difference = $difference - $randomInvestment->amount_offered;

            $this->multipleMatchWithdrawal($difference, $withdrawer);
            return 'Yeah';
        }

        if($randomInvestment->amount_offered > $difference) // greater than, withdrawer is cleared
        {
            $withdrawer->multiple_matched++;
            $withdrawer->save();

            $investor = User::findOrFail($randomInvestment->user_id);
            $investor->matched = true;
            $investor->save();

            $withdrawModel = new Withdraw;
            $withdrawModel->user_id = $withdrawer->id;
            $withdrawModel->payer = $randomInvestment->user_id;
            $withdrawModel->amount = $difference;
            $withdrawModel->save();

            $difference = $randomInvestment->amount_offered - $difference;
            $this->multipleMatchInvestment($difference, $investor);

        }


    }
}
