<?php

use App\Listeners\SendWelcomeEmail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('listener dispatches welcome email and records welcome_email_sent_at timestamp', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'welcome.test@example.com',
        'welcome_email_sent_at' => null,
    ]);

    $listener = new SendWelcomeEmail;
    $listener->handle(new Registered($user));

    Mail::assertQueued(WelcomeEmail::class, function (WelcomeEmail $mail) use ($user) {
        return $mail->hasTo('welcome.test@example.com')
            && $mail->user->id === $user->id
            && $mail->sentAt !== null;
    });

    $user->refresh();
    expect($user->welcome_email_sent_at)->not->toBeNull();
});

test('listener does not re-send welcome email if timestamp already exists', function () {
    Mail::fake();

    $existingTime = now()->subDays(2);
    $user = User::factory()->create([
        'email' => 'already.welcomed@example.com',
        'welcome_email_sent_at' => $existingTime,
    ]);

    $listener = new SendWelcomeEmail;
    $listener->handle(new Registered($user));

    Mail::assertNothingQueued();
    Mail::assertNothingSent();

    $user->refresh();
    expect($user->welcome_email_sent_at->toDateTimeString())->toBe($existingTime->toDateTimeString());
});
