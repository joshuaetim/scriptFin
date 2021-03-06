<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Referral;
use App\Withdraw;
use App\Investment;
use App\Classes\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');    
    }

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

    
        

        if($investment->activation){
            $payer->active = true;
            $payer->userID = "USER".substr(time(), -3).$payer->id;
            $payer->save();

            session()->flash('status', 'User successfully activated');
            return redirect('/admin');
        }

        session()->flash('status', 'Payment successfully confirmed');
        return redirect('/admin');
    }

    public function home()
    {
        $activations = Investment::where([
            ['activation', 1],
            ['paid_complete', 0]
        ])->get();

        $userObject = new User;
        $withdrawObject = new Withdraw;

        $allUsers = $userObject->getAllUsers();
        
        $totalPending = $userObject->getTotalPendingPayouts();

        $totalBalance = $userObject->getTotalBalance();

        $totalPaid = $withdrawObject->totalPaid();

        // return var_dump($totalPaid);

        $referrers = $userObject->getReferrers();

        $referrers = collect($referrers)->sortByDesc("count");

        // return $referrers->first()["user"]->name;

        // return $activations;

        return view('admin.home', [
            'activations' => $activations,
            'title' => 'Admin Dashboard',
            'users' => $allUsers,
            'totalPending' => $totalPending,
            'totalBalance' => $totalBalance,
            'totalPaid' => $totalPaid,
            'referrers' => $referrers,
        ]);
    }

    public function paymentShow(Investment $investment)
    {
        $user = User::findOrFail($investment->user_id);
        
        return view('admin.viewPayment', [
            'investment' => $investment,
            'user' => $user
        ]);
    }

    public function showActiveUsers()
    {
        $userObject = new User;
        $activeUsers = $userObject->getAllUsers();

        return view('admin.activeUsers', [
            'users' => $activeUsers,
            'title' => 'Active Users'
        ]);
    }

    public function deleteUsers()
    {
        echo 'user deleted';
    }

    public function showAllInvestments()
    {
        $investments = Investment::where([
            ['activation', 0]
        ])->get();

        return view('admin.showAllInvestments', [
            'investments' => $investments,
            'title' => 'All Investments',
        ]);
    }

    public function showMergedWithdrawals()
    {
        $withdrawObject = new Withdraw;
        $mergedWithdraws = null;

        // return $withdrawObject->getMergedWithdraws()->count();
        if($withdrawObject->getMergedWithdraws()->count()){
            $mergedWithdraws = $withdrawObject->getMergedWithdraws();
        }
        else{
            session()->flash('status', 'No merged withdraws yet');
            return redirect('/admin');
        }

        // return $mergedWithdraws;

        return view('admin.merged', [
            'title' => 'Merged Withdraws',
            'withdraws' => $mergedWithdraws,
        ]);
    }

    public function manualMerge()
    {
        $investmentObject = new Investment;
        $withdrawObject = new Withdraw;

        $payers = $investmentObject->getUnmatchedInvestments();
        $receivers = $withdrawObject->getUnmatchedWithdraws();

        return view('admin.manualMerge', [
            'title' => 'Manual Merging',
            'payers' => $payers,
            'receivers' => $receivers,
        ]);
    }
    
    public function mergeManually(Request $request)
    {
        $data = $request->validate([
            'payers' => 'required',
            'receiver' => 'required',
        ]);

        $data = collect($data)->recursive();
        $matchObject = new Match;

        // match single user
        if($data["payers"]->count() == 1){
            $matchObject->manualMatching($data["payers"]->first(), $data["receiver"]);
            // return $investment;
        }
        else{
            // match multiple users

            foreach ($data["payers"] as $payer) {
                $matchObject->manualMatching($payer, $data["receiver"]);
            }
        }

        if(is_array($data["receiver"]) && $data["receiver"]->count() > 1){
            return redirect('/home');
        }

        session()->flash('status', 'Users successfully merged');
        return back();
    }

    public function blockUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->blocked = true;
        $user->save();

        session()->flash('status', 'User succesfully blocked');
        return back();
    }

    public function deleteUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        session()->flash('status', 'User succesfully deleted');
        return back();
    }

    public function showBlockedUsers()
    {
        $userObject = new User;
        $blockedUsers = $userObject->getBlockedUsers();

        return view('admin.blockedUsers', [
            'users' => $blockedUsers,
            'title' => 'Active Users'
        ]);
    }

    public function unblockUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->blocked = false;
        $user->save();

        session()->flash('status', 'User succesfully unblocked');
        return back();
    }

    public function createUser()
    {
        // create User
        return view('admin.createUser', [
            'title' => 'Create User',
        ]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'bank_name' => 'required',
            'password' => 'required|confirmed',
            'account_number' => 'required|min:10|numeric',
            'account_name' => 'required',
            'phone' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->phone = $request->phone;
        $user->profile_complete = true;
        $user->active = true;
        $user->level = 10;
        $user->special = true;
        $user->save();

        $user->userID = "USER".substr(time(), -3).$user->id;
        $user->save();

        // create withdraws

        $withdraw = new Withdraw;
        $withdraw->amount = $request->amount;
        $withdraw->user_id = $user->id;
        $withdraw->created_at = now();
        $withdraw->save();

        session()->flash('status', 'User created successfully');
        return redirect('/activeUsers');
    }
    

    public function referrals()
    {
        
    }


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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
