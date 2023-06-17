<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Filters\CelebrantFilter;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CelebrantFilter $filter)
    {
        return Celebrant::filter($filter)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CelebrantResource(Celebrant::findOrFail($id));
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
