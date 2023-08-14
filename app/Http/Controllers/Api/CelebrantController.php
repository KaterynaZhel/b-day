<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;

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

        if ($request->filled('dayTo')) {
            $dayTo = $request->get('dayTo');
            $query->whereDay('birthday', '<=', $dayTo);
        }

        $celebrants = $query->paginate(20);

        return CelebrantResource::collection($celebrants);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CelebrantResource(Celebrant::findOrFail($id));
    }

    /**
     * Display the nearest 10 Celebrants.
     */

    public function getUpcomingBirthdays()
    {
        $date = now();
        $celebrants = Celebrant::whereMonth('birthday', '>', $date->month)
            ->orWhere(function ($query) use ($date) {
                $query->whereMonth('birthday', '=', $date->month)
                    ->whereDay('birthday', '>=', $date->day);
            })
            ->orderByRaw("MONTH(birthday) ASC")
            ->orderByRaw("DAYOFMONTH(birthday) ASC")
            ->take(10)
            ->get();

        return CelebrantResource::collection($celebrants);
    }
}
