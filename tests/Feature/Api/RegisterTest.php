<?php

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('new user can register via the api endpoint and receive an authentication token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'John API',
        'email' => 'john.api@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
    ]);

    $response->assertCreated();
    $response->assertJsonStructure([
        'message',
        'user' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ],
        'token',
        'token_type',
    ]);

    $response->assertJson([
        'message' => 'User registered successfully.',
        'user' => [
            'name' => 'John API',
            'email' => 'john.api@example.com',
        ],
        'token_type' => 'Bearer',
    ]);

    $token = $response->json('token');
    expect($token)->not->toBeEmpty();

    $this->assertDatabaseHas('users', [
        'name' => 'John API',
        'email' => 'john.api@example.com',
    ]);

    $createdUser = User::where('email', 'john.api@example.com')->first();
    expect($createdUser->welcome_email_sent_at)->not->toBeNull();

    // Test calling protected profile endpoint with token
    $profileResponse = $this->withToken($token)->getJson('/api/profile');
    $profileResponse->assertOk();
    $profileResponse->assertJson([
        'data' => [
            'name' => 'John API',
            'email' => 'john.api@example.com',
            'welcome_email_sent_at' => $createdUser->welcome_email_sent_at->toISOString(),
        ],
    ]);
});

test('api registration sends welcome email and stores the sent timestamp', function () {
    Mail::fake();

    $response = $this->postJson('/api/register', [
        'name' => 'Sarah API',
        'email' => 'sarah.api@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
    ]);

    $response->assertCreated();

    Mail::assertQueued(WelcomeEmail::class, function (WelcomeEmail $mail) {
        return $mail->hasTo('sarah.api@example.com')
            && $mail->user->email === 'sarah.api@example.com'
            && $mail->sentAt !== null;
    });

    $user = User::where('email', 'sarah.api@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->welcome_email_sent_at)->not->toBeNull();
});

test('protected profile endpoint rejects unauthenticated requests', function () {
    $response = $this->getJson('/api/profile');
    $response->assertUnauthorized();
});

test('api registration validates required fields', function () {
    $response = $this->postJson('/api/register', []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});

test('api registration rejects duplicate emails', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'taken@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
});
