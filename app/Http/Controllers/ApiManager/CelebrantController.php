<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Filters\CelebrantFilter;
use App\Http\Requests\FilterCelebrantRequest;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use App\Services\AddHobbiesToCelebrantService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CelebrantRequest;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

class CelebrantController extends Controller
{

    public function index(FilterCelebrantRequest $request, CelebrantFilter $filter)
    {
        $celebrants = Celebrant::findByCompany()->filter($filter)->paginate(12);
        return CelebrantResource::collection($celebrants);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CelebrantRequest $request, FileUploadService $fileUploadService, AddHobbiesToCelebrantService $addHobbies)
    {
        $celebrant = Celebrant::create($request->validated());
        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file, 'CelebrantPhoto');
            $celebrant->photo = $filePath;
        }

        $celebrant->company_id = Auth::user()->company_id;
        $celebrant->save();
        if ($request->filled('hobbies')) {
            $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);
        }

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
            $filePath         = $fileUploadService->uploadFile($file, 'CelebrantPhoto');
            $celebrant->photo = $filePath;
        }

        if ($request->filled('hobbies')) {
            $addHobbies->addHobbiesToCelebtant($celebrant, $request->hobbies);
        }

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

}
