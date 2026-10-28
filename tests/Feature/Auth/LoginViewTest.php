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
