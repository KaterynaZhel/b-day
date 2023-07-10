<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use Carbon\Carbon;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $validated = $request->validate([
            'firstname' => 'string|max:100|min:2',
            'lastname' => 'string|max:100|min:2',
            'position' => 'numeric',
            'birthday' => 'date',
            'dateFrom' => 'date',
            'dateTo' => 'date',
        ]);

        $query = Celebrant::query();

        if ($request->filled('firstname')) {
            $firstname = $request->get('firstname');
            $query->where('firstname', 'like', "%$firstname%");
        }

        if ($request->filled('lastname')) {
            $lastname = $request->get('lastname');
            $query->where('lastname', 'like', "%$lastname%");
        }

        if ($request->filled('position')) {
            $position = $request->get('position');
            $query->where('position', 'like', "%$position%");
        }

        if ($request->filled('birthday')) {
            $birthday = $request->get('birthday');
            $query->where('birthday', 'like', "%$birthday%");
        }

        if ($request->filled('birthdayFrom')) {
            $birthdayFrom = $request->get('birthdayFrom');
            $query->where('birthday', '>=', $birthdayFrom);
        }

        if ($request->filled('birthdayTo')) {
            $birthdayTo = $request->get('birthdayTo');
            $query->where('birthday', '<=', $birthdayTo);
        }

        if ($request->filled('monthFrom')) {
            $monthFrom = $request->get('monthFrom');
            $query->whereMonth('birthday', '>=', $monthFrom);
        }

        if ($request->filled('monthTo')) {
            $monthTo = $request->get('monthTo');
            $query->whereMonth('birthday', '<=', $monthTo);
        }

        if ($request->filled('dayFrom')) {
            $dayFrom = $request->get('dayFrom');
            $query->whereDay('birthday', '>=', $dayFrom);
        }

        if ($request->filled('daytTo')) {
            $daytTo = $request->get('daytTo');
            $query->whereDay('birthday', '<=', $daytTo);
        }

        $celebrants = $query->paginate(10);

        return CelebrantResource::collection($celebrants);

        // dd($celebrants);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CelebrantResource(Celebrant::findOrFail($id));
    }
}
