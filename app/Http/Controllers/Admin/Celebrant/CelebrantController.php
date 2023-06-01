<?php

namespace App\Http\Controllers\Admin\Celebrant;

use App\Models\Celebrant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $celebrants = Celebrant::paginate(20);
        return view('admin.celebrant.index', ['celebrants' => $celebrants]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.celebrant.create');
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
            'birthday' => 'required',
            'position' => 'nullable|max:50|min:2',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        // TODO: fix image upload
        // $imageName = time() . '.' . $request->photo->extension();

        // // Public Folder
        // $request->image->move(public_path('imagesPhoto'), $imageName);

        Celebrant::create($request->all());
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