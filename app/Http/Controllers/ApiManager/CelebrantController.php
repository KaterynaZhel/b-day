<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use App\Models\Hobby;
use App\Services\AddHobbiesToCelebrantService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CelebrantRequest;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'number_days' => 'nullable|numeric',
        ]);

        if ($request->filled('number_days')) {
            $number_days = $request->input('number_days');
            return $this->nearestCelebrants($number_days);
        } else {
            $celebrants = Celebrant::where('company_id', '=', Auth::user()->company_id)->paginate(20);
            return CelebrantResource::collection($celebrants);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CelebrantRequest $request, FileUploadService $fileUploadService, AddHobbiesToCelebrantService $addHobbies)
    {
        $celebrant = Celebrant::create($request->validated());
        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file);
            $celebrant->photo = $filePath;
        } else {
            $filePath         = "adminlte/dist/img/smile.png";
            $celebrant->photo = $filePath;
        }
        $celebrant->company_id = Auth::user()->company_id;
        $celebrant->save();

        $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);

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
     * Update the specified resource in storage.
     */
    public function update(CelebrantRequest $request, FileUploadService $fileUploadService, AddHobbiesToCelebrantService $addHobbies, string $id)
    {
        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);

        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file);
            $celebrant->photo = $filePath;
        } else {
            $filePath         = "adminlte/dist/img/smile.png";
            $celebrant->photo = $filePath;
        }

        $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);

        $celebrant->update($request->all());
        return new CelebrantResource($celebrant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);
        if ($celebrant->delete()) {
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'Delete Failed'])->setStatusCode(403);
        }
    }

    public function nearestCelebrants(int $number_days)
    {
        $next_week    = [];
        $current_date = Carbon::now();
        for ($i = 0; $i <= $number_days; $i++) {
            $next_week[] = $current_date->copy()->addDay($i)->format('m-d');
        }
        ;

        $celebrants = Celebrant::where('company_id', '=', Auth::user()->company_id)->orderBy('id', 'desc')
            ->whereIn(
                DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
                $next_week
            )
            ->paginate(20);

        return CelebrantResource::collection($celebrants);
    }
}