<?php

namespace App\Http\Controllers;

use App\User;
use App\Referral;
use App\Withdraw;
use Carbon\Carbon;
use App\Investment;
use App\Classes\Match;
use App\Classes\Receiver;
use App\Classes\Activation;
use Illuminate\Http\Request;
use App\Classes\PaymentCheck;
use App\Jobs\DeleteInactiveUsers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkProfile')->except(['profile', 'updateProfile']);
        $this->middleware('checkActive')->except(['profile', 'updateProfile', 'index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** Data needed by the function */
        $userObject = new User;
        $receiverObject = new Receiver;
        $withdrawObject = new Withdraw;
        $activationObject = new Activation;
        $matchObject = new Match;
        $paymentObject = new PaymentCheck;
        $investmentObject = new Investment;
        $user = auth()->user();
        $receiver = null;
        $investment = null;
        $date = null;
        $withdrawal = null;
        $paymentDetails = null;
        $payer = null;
        $payment = null;
        $paid = null;
        $waitMessage = null;
        $paymentGroup = null;
        $singlePayment = null;
        $receiveGroup = null;
        $singleReceive = null;
        $currentInvestments = null;
        $activeInvestments = null;


        // logic starts

        if(!($user->active))
        {
            if($user->matched)
            {
                $showActivationReceiver = $receiverObject->showActivationReceiver($user); //array
                $receiver = $showActivationReceiver[0];
                $investment = $showActivationReceiver[1];
                $date = Carbon::create($investment->mature_date);
            }
            else{
                $receiver = $matchObject->matchToSuperAdmin();

                if(!$receiver){
                    return 'No users';
                } // the function returns false on seeing no user

                $investment = $activationObject->createActivationInvestment($user->id, $receiver->id);
               
                $user = $userObject->setMatched($user->id);

                // refresh investment model

                $investment = Investment::find($investment->id);

                $date = Carbon::now()->addHours(24);

                DeleteInactiveUsers::dispatch($user, $investment, $receiver)->delay($date);
            }
        }
        else{
            if($user->matched || $user->multiple_matched)
            { 
                // get payer or receiver, check for multiple
                $payer = $withdrawObject->checkPayer($user);
                $receiver = $withdrawObject->checkReceiver($user);

                if($payer["count"]){
                    // it's a payer
                    if($payer["count"] > 1){
                        $paymentGroup = $payer["collection"];
                        // return $paymentGroup;
                    }
                    else{
                        $singlePayment = $payer["collection"]->first();
                        $date = Carbon::create($singlePayment->mature_date);
                        $investment = 'nothing';
                        // return $singlePayment;

                    }
                }
                elseif($receiver["count"]){
                    // it's a receiver
                    if($receiver["count"] > 1){
                        $receiveGroup = $receiver["collection"];
                        // return $receiveGroup;
                    }
                    else{
                        $singleReceive = $receiver["collection"]->first();
                        // return $singleReceive;
                    }
                }
            }
            else{
                // get user unmatched investments
                $unmatchedInvestments = $investmentObject->getCurrentInvestments($user);
                $getActiveInvestments = $investmentObject->getActiveInvestments($user);
                if($unmatchedInvestments->count() > 0){
                    $currentInvestments = $unmatchedInvestments;
                }
                elseif($getActiveInvestments->count()){
                    $activeInvestments = $getActiveInvestments;
                }
            }
        }

        // logic ends

        // return the view, with all the data

        return view('home', [
            'user' => $user,
            'receiver' => $receiver,
            'investment' => $investment,
            'withdrawal' => $withdrawal,
            'paymentDetails' => $paymentDetails,
            'payer' => $payer,
            'date' => $date,
            'payment' => $payment,
            'paid' => $paid,
            'title' => 'Home',
            'waitMessage' => $waitMessage,
            'paymentGroup' => $paymentGroup,
            'singlePayment' => $singlePayment,
            'receiveGroup' => $receiveGroup,
            'singleReceive' => $singleReceive,
            'currentInvestments' => $currentInvestments,
            'activeInvestments' => $activeInvestments
        ]);
    }

    /** 
     * Code to show receiver of the activation Fee. 
     * 
     * @param Eloquent $user
     * 
     * @return Eloquent $receiver
     */
    

    

    public function activateNewUser()
    {

    }

    


    public function profile()
    {
        return view('user.profile', [
            'user' => auth()->user(),
            'title' => 'Update Profile'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $valid = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'bank_name' => 'required',
            'account_number' => 'required|min:10|numeric',
            'account_name' => 'required',
            'phone' => 'required'
        ]);

        // check if email exists
        $checkEmail = User::where([['email', $request->email], ['id', '!=', $user->id]])->get();

        if($checkEmail->count() > 0)
        {
            session()->flash('status', 'Profile successfully updated!');
    
            return redirect('/home');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->phone = $request->phone;

        if(!$user->profile_complete){

            $user->profile_complete = true;

            $user->save();

            session()->flash('status', 'Profile successfully updated! Enjoy the Prime Investment Platform');
    
            return redirect('/home');
        }

        $user->save();

        session()->flash('status', 'Profile successfully updated!');

        return redirect('/profile');

    }

    public function referral()
    {
        $user = auth()->user();

        $getReferrals = User::where([
            ['referral', $user->userID]
        ])->get();

        $referrals = Referral::where([
            ['referrer', $user->id]
        ])->get();

        return view('referral', [
            'title' => 'Referrals',
            'user' => $user,
            'referrals' => $referrals,
            'getReferrals' => $getReferrals,
        ]);
    }
}
