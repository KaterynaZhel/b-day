<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Filters\CelebrantFilter;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use Carbon\Carbon;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CelebrantFilter $filter)
    {

        $validated = $request->validate([
            'firstname' => 'string|max:100|min:2',
            'lastname' => 'string|max:100|min:2',
            'position' => 'numeric',
            'birthday' => 'date',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'limit' => 'nullable|numeric',
        ]);

        if ($request->filled('limit')) {

            // Select the nearest Celebrants
            $limit = $request->input('limit');
            $date = Carbon::now();
            $new_date = Carbon::createFromFormat('m-d', '01-01');

            $closestBirthdayPeople = Celebrant::whereMonth('birthday', '>', $date->month)
                ->orWhere(function ($query) use ($date) {
                    $query->whereMonth('birthday', '=', $date->month)
                        ->whereDay('birthday', '>=', $date->day);
                })
                ->orderByRaw("MONTH(birthday) ASC")
                ->orderByRaw("DAYOFMONTH(birthday) ASC")
                ->take($limit)
                ->get();

            if ($closestBirthdayPeople->count() < $limit) {
                $additionalCount = $limit - $closestBirthdayPeople->count();

                // Fetch additional records to get the desired limit
                $additionalBirthdayPeople = Celebrant::whereMonth('birthday', '>', $new_date->month)
                    ->orWhere(function ($query) use ($new_date) {
                        $query->whereMonth('birthday', '=', $new_date->month)
                            ->whereDay('birthday', '>=', $new_date->day);
                    })
                    ->orderByRaw("MONTH(birthday) ASC")
                    ->orderByRaw("DAYOFMONTH(birthday) ASC")
                    ->take($additionalCount)
                    ->get();
                $closestBirthdayPeople = $closestBirthdayPeople->concat($additionalBirthdayPeople);
            }
            return CelebrantResource::collection($closestBirthdayPeople);
        } else {
            $celebrants = Celebrant::filter($filter)->paginate(20);
            return CelebrantResource::collection($celebrants);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CelebrantResource(Celebrant::findOrFail($id));
    }
}