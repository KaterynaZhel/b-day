<?php

namespace App\Http\Controllers\ApiManager;

use App\Casts\CelebrantPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionCelebrantController extends Controller
{
    public function index()
    {
        return response()->json(CelebrantPosition::$positions);
    }
}