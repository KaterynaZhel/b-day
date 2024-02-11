<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Jobs\SendEmailToManagerAboutNearestCelebrants;
use App\Jobs\SendEmailToVoteForGift;
use App\Models\Celebrant;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{

    /**
     * Send email to employees to vote for gift.
     */
    public function sendEmail(EmailRequest $request)
    {

        try {
            $selectedEmployeeIds = $request->input('selectedEmployeeIds');

            // Convert comma-separated IDs to an array
            $selectedEmployeeIdsArray = explode(',', $selectedEmployeeIds);

            $celebrant_id = $request->input('celebrant_id');
            $vote         = Vote::where('celebrant_id', $celebrant_id)->latest()->first();
            if (!$vote) {
                throw new \Exception('Vote not found.');
            }

            $celebrant = Celebrant::findByCompany()->findOrFail($celebrant_id);

            $employees = Celebrant::findByCompany()
                ->whereNotIn('id', array_merge($selectedEmployeeIdsArray, [$celebrant_id]))
                ->get();

            $vote->emails_sent = $employees->count();
            $vote->save();

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

    /**
     * Send email to Manager about nearest celebrants.
     */
    public function sendEmailToManagerAboutNearestCelebrants()
    {
        try {
            $managers = User::whereHas('celebrants', function ($query) {
                $query->nearestBirthdays(10);
            })->get();

            foreach ($managers as $manager) {
                $celebrants = $manager->celebrants()->nearestBirthdays(10)->get();
                dispatch(new SendEmailToManagerAboutNearestCelebrants($celebrants, $manager))->delay(now()->addMinutes(1));
            }
            Log::info('Emails to managers about nearest celebrants sent successfully');
            return response()->json(['message' => 'Emails to managers about nearest celebrants sent successfully']);
        } catch (\Exception $e) {
            Log::error('Exception in sendEmailToManagerAboutNearestCelebrants: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
