<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $user = User::first();
        event(new UserRegistered( $user));

        return response()->json(['message' => 'Notification has sended!', 'data' => $user]);
    }
}
