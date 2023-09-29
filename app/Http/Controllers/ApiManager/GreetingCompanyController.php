<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\GreetingCompanyResource;
use App\Models\GreetingCompany;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GreetingCompanyController extends Controller
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
            $greetingsCompany = GreetingCompany::where('company_id', '=', Auth::user()->company_id)->paginate(20);
            return GreetingCompanyResource::collection($greetingsCompany);
        }
    }

    /**
     * Filter for the nearest celebrants.
     */

    public function nearestCelebrants(int $number_days)
    {
        $next_week    = [];
        $current_date = Carbon::now();
        for ($i = 0; $i <= $number_days; $i++) {
            $next_week[] = $current_date->copy()->addDay($i)->format('m-d');
        };

        $greetingsCompany = GreetingCompany::where('greeting_companies.company_id', '=', Auth::user()->company_id)
            ->select('greeting_companies.*', 'celebrants.birthday')
            ->join('celebrants', 'celebrants.id', '=', 'greeting_companies.celebrant_id')
            ->orderBy('celebrants.birthday', 'desc')
            ->whereIn(
                DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
                $next_week
            )
            ->paginate(20);

        return GreetingCompanyResource::collection($greetingsCompany);
    }
}
