<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        if (! $user instanceof User || empty($user->email)) {
            return;
        }

        if ($user->welcome_email_sent_at !== null) {
            return;
        }

        $sentAt = now();

        Mail::to($user)->send(new WelcomeEmail($user, $sentAt));

        $user->forceFill([
            'welcome_email_sent_at' => $sentAt,
        ])->save();
    }
}
