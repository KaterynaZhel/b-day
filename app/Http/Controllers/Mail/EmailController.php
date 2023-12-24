<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Jobs\SendEmailToVoteForGift;
use App\Models\Celebrant;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function sendEmail(EmailRequest $request)
    {

        try {
            $company_id = Auth::user()->company_id;
            $selectedEmployeeIds = $request->input('selectedEmployeeIds');

            // Convert comma-separated IDs to an array
            $selectedEmployeeIdsArray = explode(',', $selectedEmployeeIds);

            $celebrant_id = $request->input('celebrant_id');
            $vote = Vote::where('celebrant_id', $celebrant_id)->first();
            if (!$vote) {
                throw new \Exception('Vote not found.');
            }

            $celebrant = Celebrant::findByCompany()->findOrFail($celebrant_id);

            $employees = Celebrant::where('company_id', $company_id)
                ->whereNotIn('id', array_merge($selectedEmployeeIdsArray, [$celebrant_id]))
                ->get();

            foreach ($employees as $employee) {
                dispatch(new SendEmailToVoteForGift($employee, $vote, $celebrant))->delay(now()->addMinutes(1));
            }
            Log::info('Vote invitations sent successfully');
            return response()->json(['message' => 'Vote invitations sent successfully']);
        } catch (\Exception $e) {
            Log::error('Exception in sendEmail: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
