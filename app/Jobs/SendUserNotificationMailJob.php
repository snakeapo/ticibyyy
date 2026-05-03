<?php

namespace App\Jobs;

use App\Mail\GenericNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserNotificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;
    public int $backoff = 10;

    public function __construct(
        public string $email,
        public string $subject,
        public string $message,
        public ?string $url = null
    ) {
        $this->onConnection(config('queue.default'));
        $this->onQueue(config('queue.mail_queue_name', 'emails'));
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(
            new GenericNotificationMail($this->subject, $this->message, $this->url)
        );
    }
}
