<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{

    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'verified']);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    }
}