<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'referral',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setMatched($user)
    {
        $user = User::find($user);
        $user->matched = true;
        $user->save();

        return $user;
    }

    public function getAllUsers()
    {
        $allUsers = User::where([
            ['active', 1],
            ['blocked', 0]
        ])->get();

        return $allUsers;
    }

    public function getTotalPendingPayouts()
    {
        $allUsers = User::all();
        $totalPending = 0;

        foreach ($allUsers as $user) {
            $totalPending += $user->pending_payout;
        }
        return $totalPending;
    }

    public function getTotalBalance()
    {
        $allUsers = User::all();
        $totalBalance = 0;

        foreach ($allUsers as $user) {
            $totalBalance += $user->balance;
        }
        return $totalBalance;
    }

    public function getActiveUsers()
    {
        
    }

    public function getReferrers()
    {
        $allUsers = $this->getAllUsers();

        $userArray = [];

        foreach ($allUsers as $user) {
            $userArray[] = ['user' => $user, 'count' => countReferrals($user)];
        }

        return $userArray;
    }
}
