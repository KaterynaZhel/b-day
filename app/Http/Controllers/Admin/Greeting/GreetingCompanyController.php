<?php

namespace App\Http\Controllers\Admin\Greeting;

use App\Models\Celebrant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GreetingCompanyRequest;
use App\Models\Company;
use App\Models\GreetingCompany;

class GreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($celebrant_id)
    {
        $greetingsCompany = GreetingCompany::where('celebrant_id', $celebrant_id)->get();
        return view('admin.greetingsCompany.index', compact('greetingsCompany', 'celebrant_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($celebrant_id)
    {
        return view('admin.greetingsCompany.create', compact('celebrant_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GreetingCompanyRequest $request, $celebrant_id)
    {
        $greetingsCompany             = new GreetingCompany($request->all() + ['celebrant_id' => $celebrant_id]);
        $celebrant                    = Celebrant::find($celebrant_id);
        $greetingsCompany->publish_at = self::GreetingDate($celebrant_id);
        $greetingsCompany->company_id = $celebrant->company_id;
        $greetingsCompany->save();
        return redirect()->route('admin.celebrants.show', $celebrant_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($celebrant_id, GreetingCompany $greetingsCompany)
    {
        return view('admin.greetingsCompany.edit', compact('celebrant_id', 'greetingsCompany'), ['companies' => Company::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($celebrant_id, GreetingCompany $greetingsCompany)
    {
        $greetingsCompany->update(request(['message_company', 'company_id']));
        return redirect()->route('admin.celebrants.show', $celebrant_id)->withSuccess('Привітання від Компанії було успішно оновлене');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($celebrant_id, GreetingCompany $greetingsCompany)
    {
        $greetingsCompany->delete();
        return redirect()->route('admin.celebrants.show', $celebrant_id)->withSuccess('Привітання від Компанії було успішно видалено');
    }

    /**
     * Generate date for publishing greeting company
     * @param int $celebrant_id
     * @return mixed
     */

    public static function GreetingDate(int $celebrant_id)
    {
        $birthday            = Celebrant::where('id', $celebrant_id)->value('birthday');
        $birthdayCurrentYear = Carbon::create($birthday)->year(now()->format('Y'))->format('Y-m-d');
        $dateNow             = Carbon::now()->startOfDay();
        if (Carbon::create($birthdayCurrentYear)->gte($dateNow)) {
            return $birthdayCurrentYear;
        } else {

            return Carbon::create($birthdayCurrentYear)->addYear(1)->format('Y-m-d');
        }
    }
}
