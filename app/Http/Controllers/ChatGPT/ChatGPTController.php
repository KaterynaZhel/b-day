<?php

namespace App\Http\Controllers\ChatGPT;

use App\Http\Controllers\Controller;
use App\Models\Celebrant;
use App\Services\GiftService;
use Illuminate\Support\Facades\Auth;

class ChatGPTController extends Controller
{
    protected $httpClient;



    public function askToChatGpt(string $id, GiftService $giftService)
    {

        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);

        return $giftService->generateGifts($celebrant);
    }
}