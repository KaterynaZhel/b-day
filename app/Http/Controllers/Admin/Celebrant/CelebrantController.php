<?php

namespace App\Http\Controllers\Admin\Celebrant;

use App\Casts\CelebrantPosition;
use App\Models\Celebrant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $celebrants = Celebrant::orderBy('id', 'desc')->paginate(20);
        return view('admin.celebrant.index', ['celebrants' => $celebrants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.celebrant.create', ['celebrant_positions' => CelebrantPosition::$positions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lastname' => 'required|max:100|min:2',
            'firstname' => 'required|max:100|min:2',
            'middlename' => 'nullable|max:100|min:2',
            'birthday' => 'required|date_format:Y-m-d',
            'position' => ['nullable', Rule::in(CelebrantPosition::$positions)],
            'photoFile' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Celebrant::create($request->all());
        $celebrant = new Celebrant($request->all());

        if (is_uploaded_file($request->file('photoFile'))) {
            $path             = $request->file('photoFile')->store('public/CelebrantPhoto');
            $celebrant->photo = $path;
        }

        $celebrant->save();

        return redirect()->route('admin.celebrant.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $celebrant = Celebrant::find($id);

        return view('admin.celebrant.show', ['celebrant' => $celebrant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $celebrant = Celebrant::find($id);

        return view('admin.celebrant.edit', ['celebrant' => $celebrant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $celebrant = Celebrant::find($id);
        $celebrant->update(request(['photo', 'lastname', 'firstname', 'middlename', 'birthday', 'position']));
        $celebrant->save();
        return redirect('admin/celebrant')->withSuccess('Іменинник був успішно оновлений');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Celebrant::find($id)->delete();
        return redirect('admin/celebrant')->withSuccess('Іменинник успішно видалений з бази даних Компанії');
    }
}
