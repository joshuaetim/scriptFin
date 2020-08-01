<?php

namespace App\Jobs;

use App\User;
use App\Withdraw;
use App\Investment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class to block user for refusal to pay investment
 * Normally 3 days for level 1 people
 */
class BlockUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $withdrawal;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Withdraw $withdrawal)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(! ($this->withdrawal->submitted_payment))
        {
            $this->user->blocked = true;
            $this->user->save();

            $this->withdrawal->complete_matched = false;
            $this->withdrawal->save();
        }
    }
}
