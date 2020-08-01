<?php

namespace App\Jobs;

use App\User;
use Carbon\Carbon;
use App\Investment;
use App\Classes\Match;
use App\Jobs\BlockUser;
use Illuminate\Bus\Queueable;
use App\Notifications\MatchResult;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class MatchUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $investment;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Investment $investment)
    {
        $this->investment = $investment;
        $this->user = $user; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $matchObject = new Match;
        $matchMessage = $matchObject->matchUsersNormally($this->investment, $this->user);

        $this->user->notify(new MatchResult($matchMessage));
    }
    
}
