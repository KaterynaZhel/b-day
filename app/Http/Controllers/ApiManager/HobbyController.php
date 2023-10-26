<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\HobbyResource;
use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{


    public function index(Request $request)
    {
        $validated = $request->validate([
            'hobby' => 'string|max:100|min:2',
        ]);

        $hobby = $request->query('hobby');

        $hobbies = Hobby::where('name', 'like', '%' . $hobby . '%')->pluck('name');

        return response()->json($hobbies);
    }
}