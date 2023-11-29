<?php

namespace App\Http\Controllers\ChatGPT;

use App\Http\Controllers\Controller;
use App\Models\Celebrant;
use App\Services\GiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatGPTController extends Controller
{
    protected $httpClient;

    public function askToChatGpt(Request $request, $id, GiftService $giftService)
    {
        $validated = $request->validate([
            'gift_budget' => 'numeric',
        ]);

        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);

        $celebrant->gift_budget = $request->input('gift_budget');
        $celebrant->save();




        return $giftService->generateGifts($celebrant);
    }
}