<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertOk();
    $response->assertSee('Welcome back');
    $response->assertSee('/api/login');
    $response->assertDontSee('Token-based 256-bit encrypted authentication');
});

test('opening the app root route shows login page instead of register page', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Welcome back');
    $response->assertSee('/api/login');
    $response->assertDontSee('Create your account');
});

test('home screen can be rendered for guest', function () {
    $response = $this->get('/home');

    $response->assertOk();
    $response->assertSee('Welcome to your application workspace');
    $response->assertSee('Guest Session');
});

test('home screen renders first name only and dashboard when authenticated via web session', function () {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'Sarah Connor',
    ]);

    /** @var TestCase $this */
    $response = $this->actingAs($user)->get('/home');

    $response->assertOk();
    $response->assertSee('Sarah');
    $response->assertDontSee('Sarah Connor');
    $response->assertSee('Active Dashboard');
    $response->assertDontSee('Guest Session');
});

test('home screen includes client-side script for dynamic token authentication', function () {
    $response = $this->get('/home');

    $response->assertOk();
    $response->assertSee('auth_token');
    $response->assertSee('/api/logout');
    $response->assertSee('/api/profile');
});

test('authenticated session user can log out via web logout route', function () {
    /** @var User $user */
    $user = User::factory()->create();

    /** @var TestCase $this */
    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('web responses contain cache control headers to prevent back button history after logout', function () {
    $response = $this->get('/home');

    $response->assertOk();
    $response->assertHeader('Pragma', 'no-cache');
    expect($response->headers->get('Cache-Control'))->toContain('no-store');
    expect($response->headers->get('Cache-Control'))->toContain('no-cache');
});

test('after web logout navigating back to home requires logging in again and does not show dashboard', function () {
    /** @var User $user */
    $user = User::factory()->create([
        'name' => 'Sarah Connor',
    ]);

    /** @var TestCase $this */
    // User is logged in and sees dashboard
    $homeResponse = $this->actingAs($user)->get('/home');
    $homeResponse->assertOk();
    $homeResponse->assertSee('Sarah');
    $homeResponse->assertSee('Active Dashboard');

    // User logs out
    $logoutResponse = $this->actingAs($user)->post('/logout');
    $logoutResponse->assertRedirect(route('login'));
    $this->assertGuest();

    // User clicks back button (requesting /home again as logged-out user)
    $backResponse = $this->get('/home');
    $backResponse->assertOk();
    $backResponse->assertDontSee('Sarah');
    $backResponse->assertSee('Guest Session');
    $backResponse->assertHeader('Pragma', 'no-cache');
    expect($backResponse->headers->get('Cache-Control'))->toContain('no-store');
    expect($backResponse->headers->get('Cache-Control'))->toContain('no-cache');
});

test('session is configured to expire on browser close', function () {
    expect(config('session.expire_on_close'))->toBeTrue();
});
