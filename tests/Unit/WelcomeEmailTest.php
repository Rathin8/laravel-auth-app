<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tests\TestCase;

uses(TestCase::class);

test('welcome email implements ShouldQueue and sets subject', function () {
    $user = new User([
        'name' => 'Jane Developer',
        'email' => 'jane@example.com',
    ]);

    $mailable = new WelcomeEmail($user);

    expect($mailable)->toBeInstanceOf(ShouldQueue::class);
    expect($mailable->envelope()->subject)->toBe('Welcome to '.config('app.name', 'Laravel').'!');
});

test('welcome email renders recipient name, email address, and sent timestamp in html in Asia/Kolkata timezone', function () {
    $user = new User([
        'name' => 'Jane Developer',
        'email' => 'jane@example.com',
    ]);
    $sentAt = Carbon::create(2026, 11, 15, 14, 30, 0, 'Asia/Kolkata');

    $mailable = new WelcomeEmail($user, $sentAt);

    $mailable->assertSeeInHtml('Welcome, Jane Developer!');
    $mailable->assertSeeInHtml('jane@example.com');
    $mailable->assertSeeInHtml($sentAt->timezone('Asia/Kolkata')->toDayDateTimeString());
    $mailable->assertSeeInHtml('(IST)');
    $mailable->assertSeeInOrderInHtml([
        'Welcome, Jane Developer!',
        'jane@example.com',
        '(IST)',
    ]);
});
