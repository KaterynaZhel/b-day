<?php

namespace App\Jobs;

use App\Http\Controllers\Mail\EmailController;
use App\Mail\EmailToManagerAboutNearestCelebrants;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailToManagerAboutNearestCelebrants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $celebrants;
    protected $manager;

    /**
     * Create a new job instance.
     */
    public function __construct(Collection $celebrants, User $manager)
    {
        $this->celebrants = $celebrants;
        $this->manager = $manager;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->manager->email)->send(new EmailToManagerAboutNearestCelebrants($this->celebrants, $this->manager));
            Log::info("Email sent successfully to: " . $this->manager->email);
        } catch (\Throwable $th) {
            Log::error("Failed to send email to: " . $this->manager->email . " Error: " . $th->getMessage());
        }
    }
}
