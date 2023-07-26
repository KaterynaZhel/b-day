<?php

namespace App\Http\Controllers\Admin\Celebrant;

use App\Casts\CelebrantPosition;
use App\Http\Requests\CelebrantRequest;
use App\Models\Celebrant;
use App\Http\Controllers\Controller;
use App\Models\GreetingCompany;
use Database\Seeders\CelebrantSeeder;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $celebrants = Celebrant::query()
            ->when(
                $request->search,
                function (Builder $builder) use ($request) {
                    $builder->where('firstname', 'like', "%{$request->search}%")
                        ->orWhere('lastname', 'like', "%{$request->search}%");
                }
            )
            ->paginate(10);
        return view('admin.celebrants.index', ['celebrants' => $celebrants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.celebrants.create', ['celebrant_positions' => CelebrantPosition::$positions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CelebrantRequest $request)
    {
        $celebrant = new Celebrant($request->all());

        if (is_uploaded_file($request->file('photoFile'))) {
            $path             = $request->file('photoFile')->store('public/CelebrantPhoto');
            $celebrant->photo = $path;
        }

        $celebrant->save();

        return redirect()->route('admin.celebrants.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $celebrant = Celebrant::find($id);
        $greetingsCompany = GreetingCompany::all()->where('celebrant_id', "==", $id);
        return view('admin.celebrants.show', compact('celebrant', 'greetingsCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $celebrant = Celebrant::find($id);
        return view('admin.celebrants.edit', ['celebrant' => $celebrant, 'celebrant_positions' => CelebrantPosition::$positions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CelebrantRequest $request, string $id)
    {
        $celebrant = Celebrant::find($id);
        $celebrant->update(request(['photo', 'lastname', 'firstname', 'middlename', 'birthday', 'position']));
        $celebrant->save();
        return redirect('admin/celebrants')->withSuccess('Іменинник був успішно оновлений');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Celebrant::find($id)->delete();
        return redirect('admin/celebrants')->withSuccess('Іменинник успішно видалений з бази даних Компанії');
    }
}
