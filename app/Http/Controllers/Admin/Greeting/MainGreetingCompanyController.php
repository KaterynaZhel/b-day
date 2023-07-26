<?php

namespace App\Http\Controllers\Admin\Greeting;

use App\Models\GreetingCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MainGreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return GreetingCompany::select("name_company as value", "id")
                ->where('name_company', 'LIKE', '%' . $request->get('search') . '%')
                ->get();
        }
        $greeting = GreetingCompany::orderBy('id', 'desc');
        if ($request->filled('search')) {
            $greeting->where('name_company', $request->get('search'));
        }
        $greeting = $greeting->paginate(20);

        return view('admin.greetingsCompany.index', ['greetingsCompany' => $greeting]);
    }

}