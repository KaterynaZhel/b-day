<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GreetingCompanyResource;
use App\Models\GreetingCompany;

class GreetingCompanyController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(string $celebrant_id)
    {
        validator(['celebrant_id' => $celebrant_id], [
            'celebrant_id' => 'numeric',
        ])->validate();

        $greetingsCompany = GreetingCompany::where('celebrant_id', $celebrant_id)
            ->where('publish_at', '<=', date('Y-m-d'))
            ->orderByDesc('id')->firstOrFail();


        return new GreetingCompanyResource($greetingsCompany);
    }

}