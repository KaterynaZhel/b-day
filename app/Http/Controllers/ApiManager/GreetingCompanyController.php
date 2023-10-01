<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResources\GreetingCompanyResource;
use App\Models\GreetingCompany;
use App\Services\FilterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterService $fileterService)
    {

        $validated = $request->validate([
            'number_days' => 'nullable|numeric',
        ]);

        switch (true) {
            case $request->filled('number_days'):
                $number_days = $request->input('number_days');
                return $fileterService->nearestCelebrants($number_days);
                break;
            default:
                $greetingsCompany = GreetingCompany::where('company_id', '=', Auth::user()->company_id)->paginate(20);
                return GreetingCompanyResource::collection($greetingsCompany);
                break;
        }
    }
}
