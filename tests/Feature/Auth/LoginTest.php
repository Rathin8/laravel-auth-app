<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertSuccessful();
    $response->assertSee('Welcome back');
    $response->assertSee('Remember me');
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create([
        'email' => 'john.doe@example.com',
        'password' => 'SecretPassword123!',
    ]);

    $response = $this->post('/login', [
        'email' => 'john.doe@example.com',
        'password' => 'SecretPassword123!',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create([
        'email' => 'john.doe@example.com',
        'password' => 'SecretPassword123!',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'john.doe@example.com',
        'password' => 'WrongPassword',
    ]);

    $this->assertGuest();
    $response->assertRedirect('/login');
    $response->assertSessionHasErrors([
        'password' => 'The provided password is incorrect.',
    ]);
});

test('users cannot authenticate with non-existent email', function () {
    $response = $this->from('/login')->post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'AnyPassword123!',
    ]);

    $this->assertGuest();
    $response->assertRedirect('/login');
    $response->assertSessionHasErrors([
        'email' => 'No account found with this email address.',
    ]);
});

test('users can authenticate and be remembered when remember me is checked', function () {
    $user = User::factory()->create([
        'email' => 'john.remember@example.com',
        'password' => 'SecretPassword123!',
        'remember_token' => null,
    ]);

    $response = $this->post('/login', [
        'email' => 'john.remember@example.com',
        'password' => 'SecretPassword123!',
        'remember' => '1',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));

    // Verify remember token is persisted on the user model
    $user->refresh();
    expect($user->remember_token)->not->toBeNull();

    // Verify recaller cookie is present on the response
    $recallerCookie = Auth::guard()->getRecallerName();
    $response->assertCookie($recallerCookie);
});

test('users are not remembered when remember me is unchecked', function () {
    $user = User::factory()->create([
        'email' => 'john.noremember@example.com',
        'password' => 'SecretPassword123!',
        'remember_token' => null,
    ]);

    $response = $this->post('/login', [
        'email' => 'john.noremember@example.com',
        'password' => 'SecretPassword123!',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));

    $user->refresh();
    expect($user->remember_token)->toBeNull();

    $recallerCookie = Auth::guard()->getRecallerName();
    $response->assertCookieMissing($recallerCookie);
});

test('authenticated users can log out', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});

test('users cannot authenticate when rate limited', function () {
    Event::fake([Lockout::class]);

    $user = User::factory()->create([
        'email' => 'locked.user@example.com',
        'password' => 'ValidPassword123!',
    ]);

    // Exceed rate limit (5 attempts)
    for ($i = 0; $i < 5; $i++) {
        $this->post('/login', [
            'email' => 'locked.user@example.com',
            'password' => 'WrongPassword',
        ]);
    }

    // 6th attempt should trigger lockout
    $response = $this->post('/login', [
        'email' => 'locked.user@example.com',
        'password' => 'ValidPassword123!',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();

    Event::assertDispatched(Lockout::class);
});
