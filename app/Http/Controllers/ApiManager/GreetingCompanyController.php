<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\GreetingCompanyResource;
use App\Models\GreetingCompany;
use App\Services\GreetingCompanyFilterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GreetingCompanyFilterService $greetingCompanyfileterService)
    {

        $validated = $request->validate([
            'number_days' => 'nullable|numeric',
        ]);

        if ($request->filled('number_days')) {
            $number_days = $request->input('number_days');
            return $greetingCompanyfileterService->nearestCelebrants($number_days);
        } else {
            $greetingsCompany = GreetingCompany::where('company_id', '=', Auth::user()->company_id)->paginate(20);
            return GreetingCompanyResource::collection($greetingsCompany);
        }
    }
}
