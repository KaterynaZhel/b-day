<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\GreetingResource;
use App\Models\Greeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $greetings = Greeting::orderBy('greetings.id', 'desc')
            ->select('greetings.*')
            ->where('company_id', '=', Auth::user()->company_id)
            ->leftjoin('celebrants', 'greetings.celebrant_id', '=', 'celebrants.id')
            ->paginate(20);
        return GreetingResource::collection($greetings);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}