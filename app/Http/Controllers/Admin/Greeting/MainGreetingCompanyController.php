<?php

namespace App\Http\Controllers\Admin\Greeting;

use App\Models\GreetingCompany;
use App\Http\Controllers\Controller;


class MainGreetingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $greeting = GreetingCompany::orderBy('id', 'desc')->paginate(20);
        return view('admin.greetingsCompany.index', ['greetingsCompany' => $greeting]);
    }

}