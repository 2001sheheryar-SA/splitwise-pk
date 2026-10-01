<?php

namespace App\Jobs;

use App\Notifications\EmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class EmailJob implements ShouldQueue
{
   use  Queueable;

    /**
     * Create a new job instance.
     */

    public string $to;
    private string $token;
    private string $expires;
    private int $invite;


    public function __construct(string $to,string $token, string $expires,int $invite)
    {
        $this->to = $to;
        $this->token = $token;
        $this->expires = $expires;
        $this->invite = $invite;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    
          Notification::route('mail', $this->to)
          ->notify(new EmailNotification($this->token,$this->expires,$this->invite));
    }
}
