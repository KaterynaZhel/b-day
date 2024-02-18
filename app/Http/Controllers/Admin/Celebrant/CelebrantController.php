<?php

namespace App\Http\Controllers\Admin\Celebrant;

use App\Casts\CelebrantPosition;
use App\Http\Requests\CelebrantRequest;
use App\Models\Celebrant;
use App\Http\Controllers\Controller;
use App\Http\Requests\CelebrantUpdateRequest;
use App\Models\Company;
use App\Models\GreetingCompany;
use App\Models\Hobby;
use App\Services\AddHobbiesToCelebrantService;
use Carbon\Carbon;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $celebrants = Celebrant::orderBy('id', 'desc')->get();
        return view('admin.celebrants.index', ['celebrants' => $celebrants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.celebrants.create', [
            'celebrant' => null,
            'celebrant_positions' => CelebrantPosition::$positions,
            'companies' => Company::all(),
            'hobbies' => Hobby::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CelebrantRequest $request, FileUploadService $fileUploadService, AddHobbiesToCelebrantService $addHobbies)
    {
        $celebrant = new Celebrant($request->all());

        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file, 'CelebrantPhoto');
            $celebrant->photo = $filePath;
        }

        $celebrant->save();

        $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);

        return redirect()->route('admin.celebrants.index')->withSuccess('Іменинник був успішно створений');
    }


    /**
     * Display the specified resource.
     */
    public function show(Celebrant $celebrant)
    {
        $greetingsCompany = GreetingCompany::all()->where('celebrant_id', "==", $celebrant->id);
        return view('admin.celebrants.show', compact('celebrant', 'greetingsCompany'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Celebrant $celebrant)
    {
        return view('admin.celebrants.edit', [
            'celebrant' => $celebrant,
            'celebrant_positions' => CelebrantPosition::$positions,
            'companies' => Company::all(),
            'hobbies' => Hobby::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CelebrantUpdateRequest $request, Celebrant $celebrant, FileUploadService $fileUploadService, AddHobbiesToCelebrantService $addHobbies)
    {
        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file, 'CelebrantPhoto');
            $celebrant->photo = $filePath;
        }

        $celebrant->update(request(['lastname', 'firstname', 'middlename', 'birthday', 'email', 'company_id', 'position']));

        $celebrant->save();
        $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);
        return redirect('admin/celebrants')->withSuccess('Іменинник був успішно оновлений');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Celebrant $celebrant)
    {
        $celebrant->delete();
        return redirect('admin/celebrants')->withSuccess('Іменинник успішно видалений з бази даних Компанії');
    }

    public function nearestCelebrants()
    {
        $next_week    = [];
        $current_date = Carbon::now();
        for ($i = 0; $i <= 7; $i++) {
            $next_week[] = $current_date->copy()->addDay($i)->format('m-d');
        };

        $celebrants = Celebrant::orderBy('id', 'desc')
            ->whereIn(
                DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
                $next_week
            )
            ->paginate(20);

        return view('admin.celebrants.nearestCelebrants', ['celebrants' => $celebrants]);
    }
}