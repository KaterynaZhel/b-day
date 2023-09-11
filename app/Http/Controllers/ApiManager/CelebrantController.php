<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\CelebrantResource;
use App\Models\Celebrant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CelebrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $celebrants = Celebrant::where('company_id', '=', Auth::user()->company_id)->paginate(20);
        return CelebrantResource::collection($celebrants);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function nearestCelebrants()
    {
        $next_week    = [];
        $current_date = Carbon::now();
        for ($i = 0; $i <= 7; $i++) {
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