<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GreetingResource;
use App\Models\Greeting;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|max:100|min:2',
            'message' => 'string|max:64000|min:2',
            'celebrant_id' => 'numeric|exists:celebrants,id',
        ]);

        $greeting = Greeting::create($request->all());

        return (new GreetingResource($greeting))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_ACCEPTED);

    }

}