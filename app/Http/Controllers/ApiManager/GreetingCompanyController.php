<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\GreetingCompanyRequest;
use App\Http\Resources\ManagerResources\GreetingCompanyResource;
use App\Models\Celebrant;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(GreetingCompanyRequest $request, $celebrant_id)
    {
        $company_id_Auth = Auth::user()->company_id;
        $company_id_Celebrant = Celebrant::where('company_id', '=', Auth::user()->company_id)->findOrFail($celebrant_id)->company_id;

        if ($company_id_Celebrant == $company_id_Auth) {
            $greetingCompany = GreetingCompany::create($request->all() + ['celebrant_id' => $celebrant_id]);
            $greetingCompany->company_id = Auth::user()->company_id;
            $greetingCompany->publish_at = app('App\Http\Controllers\Admin\Greeting\GreetingCompanyController')->GreetingDate($celebrant_id);
            $greetingCompany->save();
            return (new GreetingCompanyResource($greetingCompany))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
        }
    }
}
