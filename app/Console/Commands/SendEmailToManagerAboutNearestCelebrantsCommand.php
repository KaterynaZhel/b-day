<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\SendEmailToManagerAboutNearestCelebrants;
use Illuminate\Support\Facades\Log;

class SendEmailToManagerAboutNearestCelebrantsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-email-to-manager-about-nearest-celebrants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to manager about nearest celebrants';

    /**
     * Execute the console command to send email to Manager about nearest celebrants.
     */
    public function handle()
    {
        try {
            $managers = User::where('role', User::MANAGER_ROLE)
                ->with(['company', 'company.celebrants' => function ($query) {
                    $query->nearestBirthdays(10);
                }])
                ->get();

            foreach ($managers as $manager) {
                $celebrants = $manager->company->celebrants;
                dispatch(new SendEmailToManagerAboutNearestCelebrants($celebrants, $manager))->delay(now()->addMinutes(1));
            }
            Log::info('Emails to managers about nearest celebrants sent successfully');
        } catch (\Exception $e) {
            Log::error('Exception in sendEmailToManagerAboutNearestCelebrants: ' . $e->getMessage());
        }
    }
}
