<?php

namespace App\Http\Controllers;

use App\User;
use App\Referral;
use App\Withdraw;
use App\Investment;
use App\PaymentLog;
use Illuminate\Http\Request;
use App\Classes\InvestmentCheck;
use Illuminate\Support\Facades\Storage;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkProfile')->except(['profile', 'updateProfile']);
        $this->middleware('checkActive')->except(['profile', 'updateProfile', 'index', 'showPayment', 'confirm']);
        
    }


    public function showPayment(Withdraw $withdraw)
    {
        // get user profile of receiver
        $receiver = User::findorFail($withdraw->user_id);
        
        return view('payment.make', [
            'receiver' => $receiver,
            'withdraw' => $withdraw,
            'title' => 'Make Payment'
        ]);
    }

    public function submitPayment(Request $request)
    {
        $data = $request->validate([
            'method' => 'required',
            'bank' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'depositor_name' => 'required',
            'payment_location' => 'required',
        ]);

        $payment = PaymentLog::create($data);

        $payment->user = auth()->user()->id;

        $withdraw = Withdraw::find($request->withdrawID);
        $withdraw->submitted_payment = true;
        $withdraw->payment = $payment->id;
        $withdraw->save();

        $payment->withdraw = $withdraw->id;

        // security check to ensure user is authorizing in account

        if(auth()->user()->id == $withdraw->payer){

            $payment->receiver = $withdraw->user_id;

            if($request->hasFile('proof')){
                $name = time().'_'.$request->file('proof')->getClientOriginalName();
                Storage::putFileAs('public/images', $request->file('proof'), $name);
                $payment->proof = $name;
            }
    
            $payment->save();
    
            session()->flash('status', 'You have successfully submitted payment');
            return redirect('/home');

        }

        else{
            return redirect('/home');
        }
    }

    public function confirmPayment(Request $request)
    {
        // update withdraw field
        $withdraw = Withdraw::findOrFail($request->confirm);
        $withdraw->paid = true;
        $withdraw->save();

        $investment = Investment::findOrFail($withdraw->investment);
        $investment->amount_paid += $withdraw->amount;
        $investment->save();

        if($investment->amount_paid == $investment->main_offered)
        {
            $investment->paid_complete = true;
            $investment->save();
        }
        
        // payer field
        $payer = User::findOrFail($withdraw->payer);
        $payer->level++;
        if($payer->multiple_matched){
            $payer->multiple_matched--;
        }
        else{
            $payer->matched = false;
        }

        // give money to referrer, 10%

        if($payer->referral){
            $referrer = User::where([
                ['userID', $payer->referral]
            ])->get()->first();

            if($referrer)
            {
                $bonus = 0.1 * $investment->main_offered;
                $referrer->referral_balance += $bonus;
                $referrer->save();
                $referral = new Referral;
                $referral->user_id = $payer->id;
                $referral->referrer = $referrer->id;
                $referral->amount = $bonus;
                $referral->save();
            }
        }

        // receiver field
        $receiver = User::findOrFail($withdraw->user_id);
        if($receiver->multiple_matched){
            $receiver->multiple_matched--;
        }
        else{
            $receiver->matched = false;
        }
    
        // change account balance
        $payer->balance += $withdraw->amount + ($withdraw->amount * 0.5);
        $payer->save();

        if($receiver->pending_payout)
        {
            $receiver->pending_payout -= $withdraw->amount;
            $receiver->save();
        }

        // here, send notification to users.


        session()->flash('status', 'Payment successfully confirmed');
        
        return redirect('/home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Investment $investment)
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

        if(now() < $investment->mature_date)
        {
            session()->flash('error', 'You have to wait for your investment mature date to withdraw');
            return redirect('/home');
        }

        // check withdraw time

        $withdraw = new Withdraw;
        $withdraw->user_id = $user->id;
        $withdraw->amount = $investment->yield;
        $withdraw->save();

        $investment->withdraw = true;
        $investment->completed = true;
        $investment->save();

        $user->balance -= $withdraw->amount;
        $user->pending_payout += $withdraw->amount;
        $user->save();

        session()->flash('status', 'You have successfully made a withdrawal. Please await pairing with a member of the platform');

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdraw $withdraw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
}
