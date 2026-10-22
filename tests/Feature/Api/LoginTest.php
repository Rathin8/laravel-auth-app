<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can log in with valid credentials and receive token', function () {
    $user = User::factory()->create([
        'email' => 'jane.login@example.com',
        'password' => 'Secret123!',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'jane.login@example.com',
        'password' => 'Secret123!',
        'device_name' => 'iphone_app',
    ]);

    $response->assertOk();
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
        'message' => 'Login successful.',
        'user' => [
            'id' => $user->id,
            'email' => 'jane.login@example.com',
        ],
        'token_type' => 'Bearer',
    ]);

    $token = $response->json('token');
    expect($token)->not->toBeEmpty();

    // Verify token works on protected profile endpoint
    $profileResponse = $this->withToken($token)->getJson('/api/profile');
    $profileResponse->assertOk();
    $profileResponse->assertJsonPath('data.email', 'jane.login@example.com');
});

test('login fails with invalid password', function () {
    User::factory()->create([
        'email' => 'jane.login@example.com',
        'password' => 'CorrectPassword123!',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'jane.login@example.com',
        'password' => 'WrongPassword!',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
});

test('login fails with non-existent email', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'AnyPassword123!',
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email']);
});

test('login validates required fields', function () {
    $response = $this->postJson('/api/login', []);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email', 'password']);
});

test('authenticated user can log out and revoke their token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test_token')->plainTextToken;

    expect($user->tokens)->toHaveCount(1);

    $response = $this->withToken($token)->postJson('/api/logout');

    $response->assertOk();
    $response->assertJson([
        'message' => 'Logged out successfully.',
    ]);

    expect($user->fresh()->tokens)->toHaveCount(0);

    $this->app['auth']->forgetGuards();

    $profileResponse = $this->withToken($token)->getJson('/api/profile');
    $profileResponse->assertUnauthorized();
});

test('unauthenticated user cannot call logout', function () {
    $response = $this->postJson('/api/logout');

    $response->assertUnauthorized();
});
