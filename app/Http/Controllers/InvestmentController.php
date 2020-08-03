<?php

namespace App\Http\Controllers;

use App\User;
use App\Withdraw;
use Carbon\Carbon;
use App\Investment;
use App\Jobs\MatchUsers;
use Illuminate\Http\Request;
use App\Classes\InvestmentCheck;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkProfile');
        $this->middleware('checkActive')->except(['profile', 'updateProfile', 'index', 'showPayment', 'confirm']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function needMoreInvestment($user)
    {
        $investmentObject = new InvestmentCheck;
        $count = $investmentObject->activeInvestmentCount($user);

        if($count < 2){
            session()->flash('error', 'You have to make an investment/recommitment investment in order to withdraw');
            return redirect('/home');
        }
    }

    public function withdraw(Investment $investment)
    {
        $user = auth()->user();

        $withdraw = new Withdraw;
        $withdraw->user_id = $user->id;
        $withdraw->save();

    }
    
    public function showMaturedInvestments()
    {
        $user = auth()->user();
        
        $investmentObject = new InvestmentCheck;
        $count = $investmentObject->completeInvestmentCount($user);

        if($count < 1){
            session()->flash('error', 'You have to fulfill an investment in order to withdraw');
            return redirect('/home');
        } // check if more investment is needed

        elseif($count < 2){
            session()->flash('error', 'You have to fulfill a recommitment investment in order to withdraw');
            return redirect('/home');
        } // check if more investment is needed

        $investments = Investment::where([
            ['user_id', $user->id],
            ['paid_complete', true],
            ['activation', false],
            ['withdraw', 0],
        ])->get();

        // return $investments;

        return view('withdraw.showMaturedInvestments', [
            'title' => 'Withdraw Funds',
            'investments' => $investments
        ]);
    }

    public function withdrawInvestment(Request $request)
    {
        $amount = (int) $request->amount;

        if(is_integer($amount/1000) && $amount >= 5000){

        }

        else{
            return 'Invalid Value';
        }
    }

/** 
    * Code to match user to single, special admin with a level of 10 

    * @return Eloquent Object
    
    */


    public function confirm(Request $request)
    {
        $investment = Investment::findOrFail($request->confirm);
        $investment->paid_complete = true;
        $investment->amount_paid = $investment->amount_offered;
        $investment->save();


        $payer = User::findOrFail($investment->user_id);
        $payer->matched = false;
        $payer->level++;
        $payer->save();

        $receiver = User::findOrFail($investment->receiver);
        $receiver->matched = false;
        $receiver->save();


        $withdraw = Withdraw::where([
            ['investment_id', $investment->id]
        ])->first();
        if($withdraw){
            $withdraw->delete();
        }

        session()->flash('status', 'Payment successfully confirmed');

        if($investment->activation){
            $payer->active = true;
            $payer->save();

            if(Auth::guard('admin')->check()){
                return redirect('/admin');
            }
            else{
                return redirect('/home');
            }
        }

        else{
            $payer->balance += $investment->yield;
            $payer->save();
        }

        
        return redirect('/home');
    }

    public function showPayment(Investment $investment)
    {
        // get user profile of receiver
        $receiver = User::findorFail($investment->receiver);
        
        return view('payment.makeActivation', [
            'receiver' => $receiver,
            'investment' => $investment,
            'title' => 'Make Payment'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        
        // check if user has pending payment
        if($user->pending_payout)
        {
            session()->flash('error', 'You have pending investments to withdraw');
            return redirect('/home');
        }
        $investmentObject = new InvestmentCheck;
        $count = $investmentObject->activeInvestmentCount($user);

        if($count >= 2)
        {
            session()->flash('error', 'You have pending investments to settle/withdraw');
            return redirect('/home');
        }

        return view('createInvestment', [
            'title' => 'New Investment'
        ]);
    }

    public function makePayment(Request $request)
    {
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $amount = (int) $request->amount;
        $user = auth()->user();

        $previousInvestment = Investment::where([
            ['user_id', $user->id]
        ])->get()->last();

        if(is_integer($amount/1000) && $amount >= 5000 && $amount<=200000)
        {
            if($previousInvestment){
                if($previousInvestment->main_offered){
                    $previous = $previousInvestment->main_offered;
                    if($amount < $previous){
                        session()->flash('error', 'Your investment must be equal to or greater than the previous investment');
    
                        return redirect('/newInvestment');
                    }
                }
            }
            // check previous investment

            $investment = new Investment;
            $investment->uniqueID = "PRIME".substr(time(), -3).$user->id;
            $investment->user_id = auth()->user()->id;
            $investment->amount_offered = $amount;
            $investment->main_offered = $amount;
            $matureDays = 5;
            if($user->level <= 1)
            {
                $matureDays = 3;
                $user->level++;
                $user->save();
            }
            $investment->mature_date = now()->addDays($matureDays);
            $investment->yield = $amount + ((50/100) * $amount);

            $investment->save();

            /**
             * Schedule matching of users
             * Usually at the end of the day
             * 
             * Before that,
             * - Generate time, with end-of-day overflow
             * - generate fresh instances of required models
             * 
             */
            $time = Carbon::now()->addUnitNoOverflow('hour', 24, 'day');

            // $time = Carbon::now()->addMinutes(10);

            $user = User::find(auth()->user()->id);
            $investment = Investment::find($investment->id);

            // MatchUsers::dispatch($user, $investment)->delay($time);
            MatchUsers::dispatchNow($user, $investment);

            session()->flash('status', 'Investment Profile Created Successfully. Please await pairing with a member of the platform');

            return redirect('/home');

        }
        else
        {
            return 'The value is invalid';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investment $investment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }
}
