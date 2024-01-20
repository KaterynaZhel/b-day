<?php

namespace App\Http\Controllers\ApiManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiftOptionsRequest;
use App\Models\Celebrant;
use App\Models\Gift;


class GiftOptionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftOptionsRequest $request)
    {
        $gifts        = $request->input('gifts');
        $celebrant_id = $request->input('celebrant_id');
        $celebrant    = Celebrant::findByCompany()->findOrFail($celebrant_id);

        $createdGifts = [];
        foreach ($gifts as $gift) {

            $urlParts = parse_url($gift['link']);

            if (isset($urlParts['scheme']) && isset($urlParts['host'])) {
                $gift['link'] = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'];


                $createdGifts[] = Gift::create($gift + compact('celebrant_id'));

            }

        }

        return response($createdGifts, \Illuminate\Http\Response::HTTP_CREATED);
    }
}



