<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CelebrantRequest;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $celebrants = Celebrant::where('company_id', '=', Auth::user()->company_id)->paginate(20);
        return CelebrantResource::collection($celebrants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CelebrantRequest $request)
    {
        $celebrant = Celebrant::create($request->validated());
        $celebrant->company_id = Auth::user()->company_id;
        $celebrant->save();
        return (new CelebrantResource($celebrant))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);
        return new CelebrantResource($celebrant);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
