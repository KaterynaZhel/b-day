<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\EmailToVoteForGift;
use App\Models\Celebrant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailToVoteForGift implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;
    /**
     * Create a new job instance.
     */
    public function __construct(Celebrant $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->employee->email)->send(new EmailToVoteForGift($this->employee));
            Log::info("Email sent successfully to: " . $this->employee->email);
        } catch (\Throwable $th) {
            Log::error("Failed to send email to: " . $this->employee->email . " Error: " . $th->getMessage());
        }
    }
}
