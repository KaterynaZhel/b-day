<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ManagerResources\UserResource;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, FileUploadService $fileUploadService, string $id)
    {
        $user    = User::where('company_id', '=', Auth::user()->company_id)->findOrFail($id);
        $company = $user->company;

        $company->update(['site' => $request->company_site]);

        if ($request->hasFile('photoFile')) {
            $file        = $request->file('photoFile');
            $filePath    = $fileUploadService->uploadFile($file, 'UserPhoto');
            $user->photo = $filePath;
        }


        $user->update($request->all());
        return new UserResource($user);
    }
}