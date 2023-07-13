<?php

namespace App\Http\Controllers\Admin\Greeting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GreetingCompany;

class GreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($celebrant_id)
    {
        $greetingsCompany = GreetingCompany::where('celebrant_id', $celebrant_id)->get();
        return view('admin.greetingsCompany.index', compact('greetingsCompany', 'celebrant_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($celebrant_id)
    {
        return view('admin.greetingsCompany.create', compact('celebrant_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $celebrant_id)
    {
        $validated = $request->validate([
            'message_company' => 'required|min:2|max:500',
            'name_company' => 'required|min:2|max:30',
            'celebrant_id' => 'numeric|exists:celebrants,id',
        ]);
        $greetingsCompany = new GreetingCompany($request->all() + ['celebrant_id' => $celebrant_id]);
        $greetingsCompany->save();
        return redirect()->route('admin.celebrants.show', $celebrant_id);
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
    public function edit($celebrant_id, GreetingCompany $greetingsCompany)
    {
        return view('admin.greetingsCompany.edit', compact('celebrant_id', 'greetingsCompany'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($celebrant_id, GreetingCompany $greetingsCompany)
    {
        $greetingsCompany->update(request(['message_company', 'name_company']));
        return redirect()->route('admin.celebrants.show', $celebrant_id)->withSuccess('Привітання від Компанії було успішно оновлене');
    }
}
