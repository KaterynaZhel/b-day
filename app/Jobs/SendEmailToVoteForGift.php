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
        Mail::to($this->employee->email)
            ->send(new EmailToVoteForGift($this->employee));
    }
}
