<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\FileUploadService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(25);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'companies' => Company::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, FileUploadService $fileUploadService, User $user)
    {

        if ($request->hasFile('photoFile')) {
            $file             = $request->file('photoFile');
            $filePath         = $fileUploadService->uploadFile($file, 'UserPhoto');
            $user->photo      = $filePath;
        }

        $user->update(request(['lastname', 'name', 'middlename', 'email', 'company_id']));

        $user->save();
        return redirect('admin/users')->withSuccess('Менеджер був успішно оновлений');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
