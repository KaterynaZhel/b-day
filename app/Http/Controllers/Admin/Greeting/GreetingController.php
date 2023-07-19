<?php

namespace App\Http\Controllers\Admin\Greeting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Greeting;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $greetings = Greeting::orderBy('id', 'desc')->paginate(10);
        return view('admin.greetings.index', ['greetings' => $greetings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|min:2|max:500',
            'name' => 'required|min:2|max:30',
            'celebrant_id' => 'numeric|exists:celebrants,id',
        ]);
        $greetings = new Greeting($request->all());
        $greetings->save();
        return redirect()->route('admin.greetings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        Greeting::find($id)->delete();
        return redirect()->route('admin.greetings.index')->withSuccess('Привітання від Гостя було успішно видалено');
    }
}
