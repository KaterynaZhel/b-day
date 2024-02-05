<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Filters\GreetingFilter;
use App\Http\Requests\FilterGreetingRequest;
use App\Http\Resources\GreetingResource;
use App\Models\Celebrant;
use App\Models\Greeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterGreetingRequest $request, GreetingFilter $filter)
    {

        $greetings = Greeting::orderBy('greetings.id', 'desc')
            ->select('greetings.*')
            ->where('company_id', '=', Auth::user()->company_id)
            ->leftjoin('celebrants', 'greetings.celebrant_id', '=', 'celebrants.id')
            ->filter($filter)
            ->paginate(10);
        return GreetingResource::collection($greetings);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $greetings = Greeting::select('greetings.*')
            ->where('company_id', '=', Auth::user()->company_id)
            ->leftjoin('celebrants', 'greetings.celebrant_id', '=', 'celebrants.id')
            ->findOrFail($id);

        if ($greetings->delete()) {
            return response()->json(['message' => 'Successfully Deleted']);
        } else {
            return response()->json(['message' => 'Delete Failed'])->setStatusCode(403);
        }
    }
}