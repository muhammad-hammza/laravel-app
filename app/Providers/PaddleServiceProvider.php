<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PaddleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function createSubscription($user, $plan)
    {
        $paylink = Auth::user()->charge(50.0, "Premium");
        return view('billing', [
        'paylink' => $paylink
        ]);
        }    

    public function handleWebhook($payload)
    {
        // Handle webhook logic here
    }
}
