<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{

    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? response()->json(['message' => 'verified'])
            : response()->json(['message' => 'verify email']);


    }
}