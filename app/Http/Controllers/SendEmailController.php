<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailToAllUsersJob;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendJobAlertToAllUsers(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'title' => 'required|string',

        ]);

        $messageContent = $request->input('message');
        $title = $request->input('title');

        SendEmailToAllUsersJob::dispatch($messageContent,$title);

        return response()->json(['status' => 'Emails are being sent.'], 200);
    }
}
