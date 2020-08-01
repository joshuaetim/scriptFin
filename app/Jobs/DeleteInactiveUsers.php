<?php

namespace App\Jobs;

use App\User;
use App\Investment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteInactiveUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $investment;
    public $receiver;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Investment $investment, User $receiver)
    {
        $this->user = $user;
        $this->investment = $investment;
        $this->receiver = $receiver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(! ($this->investment->paid || $this->investment->paid_complete))
        {
            $this->user->delete();
            $this->investment->delete();
            $this->receiver->matched = false;
            $this->receiver->save();
        }
    }
}
