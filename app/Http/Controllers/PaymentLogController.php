<?php

namespace App\Http\Controllers;

use App\Investment;
use App\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkProfile');
        $this->middleware('checkActive')->except(['store']);
    }
    
    public function download($download)
    {
        return Storage::download('public/images/'.$download);
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
    public function store(Request $request)
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
        $payment->investment = $request->investmentiD;

        $investment = Investment::find($request->investmentiD);
        $investment->paid = true;
        $investment->save();


        // security check to ensure user is authorizing in account

        if(auth()->user()->id == $investment->user_id){

            $payment->receiver = $investment->receiver;

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

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentLog  $paymentLog
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentLog $paymentLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentLog  $paymentLog
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentLog $paymentLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentLog  $paymentLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentLog $paymentLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentLog  $paymentLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentLog $paymentLog)
    {
        //
    }
}
