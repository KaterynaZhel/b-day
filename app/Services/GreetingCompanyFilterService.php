<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\GreetingCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ManagerResources\GreetingCompanyResource;

class GreetingCompanyFilterService
{
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
            ->whereIn(
                DB::raw("DATE_FORMAT(birthday,'%m-%d')"),
                $next_week
            )
            ->orderByRaw("MONTH(birthday) ASC")
            ->orderByRaw("DAYOFMONTH(birthday) ASC")
            ->paginate(20);

        return GreetingCompanyResource::collection($greetingsCompany);
    }
}
