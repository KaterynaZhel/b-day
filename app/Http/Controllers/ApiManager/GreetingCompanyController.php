<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Filters\GreetingCompanyFilter;
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
    public function index(Request $request, GreetingCompanyFilter $filter)
    {
        $greetingsCompany = GreetingCompany::findByCompany()
            ->select('greeting_companies.*', 'celebrants.lastname', 'celebrants.firstname', 'celebrants.birthday')
            ->leftjoin('celebrants', 'greeting_companies.celebrant_id', '=', 'celebrants.id')
            ->orderByRaw('greeting_companies.publish_at')
            ->filter($filter)->paginate(10);
        return GreetingCompanyResource::collection($greetingsCompany);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GreetingCompanyRequest $request, $celebrant_id, GreetingCompanyFilterService $greetingCompanyfileterService)
    {
        $celebrant                     = Celebrant::findByCompany()->findOrFail($celebrant_id);
        $greetingCompany               = GreetingCompany::create($request->all() + ['celebrant_id' => $celebrant_id]);
        $greetingCompany->company_id   = Auth::user()->company_id;
        $greetingCompany->celebrant_id = $celebrant->id;
        $greetingCompany->publish_at   = $greetingCompanyfileterService->GreetingDate($celebrant_id);
        $greetingCompany->save();
        return (new GreetingCompanyResource($greetingCompany))->response()->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GreetingCompanyRequest $request, string $id)
    {
        $greetingCompany = GreetingCompany::findByCompany()->findOrFail($id);
        $greetingCompany->update($request->all());
        return new GreetingCompanyResource($greetingCompany);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $greetingCompany = GreetingCompany::findByCompany()->findOrFail($id);
        if ($greetingCompany->delete()) {
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'Delete Failed'])->setStatusCode(403);
        }
    }

    /**
     * Show greetings from the company for Celebrant.
     */
    public function showGreetingsCompanyForCelebrant(Request $request, $celebrant_id)
    {
        $validated = $request->validate([
            'celebrant' => ['numeric', 'celebrant_id' => 'exists:celebrants,id'],
        ]);

        $celebrant        = Celebrant::findByCompany()->findOrFail($celebrant_id);
        $greetingsCompany = $celebrant->greetingsCompany()->paginate(5);
        return GreetingCompanyResource::collection($greetingsCompany);
    }
}
