<?php

namespace App\Http\Controllers\ChatGPT;

use App\Http\Controllers\Controller;
use App\Models\Celebrant;
use App\Services\GiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatGPTController extends Controller
{
    protected $httpClient;

    public function askToChatGpt(Request $request, $id, GiftService $giftService)
    {
        Log::debug('start function askToChatGpt');
        $validated = $request->validate([
            'gift_budget' => 'numeric',
        ]);

        $celebrant = Celebrant::findByCompany()->findOrFail($id);

        $celebrant->gift_budget = $request->input('gift_budget');
        $celebrant->save();
        Log::debug('gift_budget ' . $celebrant->gift_budget);


        return $giftService->generateGifts($celebrant);
    }
}