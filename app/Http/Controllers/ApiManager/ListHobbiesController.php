<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\HobbyResource;
use App\Models\Hobby;
use Illuminate\Http\Request;

class ListHobbiesController extends Controller
{
    public function index()
    {
        $hobbies = Hobby::all();
        return HobbyResource::collection($hobbies);
    }
}