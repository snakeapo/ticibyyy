<?php

namespace App\Services;

use App\Jobs\SendUserNotificationMailJob;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationPreferenceMailer
{
    public function sendToUsers(Collection $users, string $subject, string $message, ?string $url = null): void
    {
        $delaySeconds = (int) config('queue.mail_rate_limit_delay_seconds', 2);

        $users
            ->filter(fn ($u) => !empty($u->email))
            ->values()
            ->each(function (User $user, int $index) use ($subject, $message, $url, $delaySeconds) {
                SendUserNotificationMailJob::dispatch($user->email, $subject, $message, $url)
                    ->delay(now()->addSeconds($index * $delaySeconds));
            });
    }
}
