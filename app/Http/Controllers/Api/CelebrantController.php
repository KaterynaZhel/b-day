<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Celebrant::limit(10);

        if ($request->filled('firstname')) {
            $firstname = $request->get('firstname');
            $query->where('firstname', 'like', "%$firstname%");
        }

        if ($request->filled('lastname')) {
            $lastname = $request->get('lastname');
            $query->where('lastname', 'like', "%$lastname%");
        }

        if ($request->filled('position')) {
            $position = $request->get('position');
            $query->where('position', 'like', "%$position%");
        }

        if ($request->filled('birthday')) {
            $birthday = $request->get('birthday');
            $query->where('birthday', 'like', "%$birthday%");
        }

        $celebrants = $query->paginate(10);

        return CelebrantResource::collection($celebrants);

        // dd($celebrants);
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
