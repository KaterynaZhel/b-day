<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailToVoteForGift;
use App\Models\Celebrant;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $company_id = $request->input('company_id');
        $selectedEmployeeIds = $request->input('selectedEmployeeIds');

        // Convert comma-separated IDs to an array
        $selectedEmployeeIdsArray = explode(',', $selectedEmployeeIds);

        $employees = Celebrant::where('company_id', $company_id)->get()
            ->whereNotIn('id', $selectedEmployeeIdsArray);

        foreach ($employees as $employee) {
            dispatch(new SendEmailToVoteForGift($employee))->delay(now()->addMinutes(1));
        }
    }
}
