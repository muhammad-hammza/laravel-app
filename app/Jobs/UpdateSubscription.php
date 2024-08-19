<?php

namespace App\Jobs;

use App\Models\order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(order $order, $planType, $newEndDate)
    {
        $this->order = $order;
        $this->planType = $planType;
        $this->newEndDate = $newEndDate;
    }
    
    public function handle()
    {
        $user = User::find($this->order->user_id);
        if ($user) {
            $user->plan_type = $this->planType;
            $user->subscription_end_date = $this->newEndDate;
            $user->save();
        }
    }
}
