<?php

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;

uses(RefreshDatabase::class);

test('redirects to google oauth provider', function () {
    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('redirect')
        ->once()
        ->andReturn(new RedirectResponse('https://accounts.google.com/o/oauth2/auth'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.redirect', 'google'));

    $response->assertRedirect('https://accounts.google.com/o/oauth2/auth');
});

test('registers and logs in a new user via google callback', function () {
    $socialUser = new SocialiteUser;
    $socialUser->id = 'google-id-123456';
    $socialUser->name = 'Google User';
    $socialUser->email = 'google.user@example.com';
    $socialUser->avatar = 'https://lh3.googleusercontent.com/avatar.jpg';
    $socialUser->token = 'mock-google-token';
    $socialUser->refreshToken = 'mock-google-refresh-token';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andReturn($socialUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'google'));

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'Google User',
        'email' => 'google.user@example.com',
        'avatar' => 'https://lh3.googleusercontent.com/avatar.jpg',
    ]);

    $this->assertDatabaseHas('social_accounts', [
        'provider' => 'google',
        'provider_id' => 'google-id-123456',
        'avatar' => 'https://lh3.googleusercontent.com/avatar.jpg',
    ]);

    $response->assertRedirect(route('home'));
});

test('logs in an existing user with linked google account', function () {
    $user = User::factory()->create([
        'name' => 'Existing User',
        'email' => 'existing@example.com',
    ]);

    SocialAccount::create([
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google-id-existing',
    ]);

    $socialUser = new SocialiteUser;
    $socialUser->id = 'google-id-existing';
    $socialUser->name = 'Existing User';
    $socialUser->email = 'existing@example.com';
    $socialUser->avatar = 'https://lh3.googleusercontent.com/avatar-updated.jpg';
    $socialUser->token = 'mock-new-token';
    $socialUser->refreshToken = 'mock-new-refresh-token';

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andReturn($socialUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'google'));

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));

    $this->assertDatabaseHas('social_accounts', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google-id-existing',
        'avatar' => 'https://lh3.googleusercontent.com/avatar-updated.jpg',
    ]);
});

test('links google account to existing user with same email', function () {
    $user = User::factory()->create([
        'name' => 'Registered User',
        'email' => 'user@example.com',
        'avatar' => null,
    ]);

    $socialUser = new SocialiteUser;
    $socialUser->id = 'google-id-new-link';
    $socialUser->name = 'Registered User';
    $socialUser->email = 'user@example.com';
    $socialUser->avatar = 'https://lh3.googleusercontent.com/photo.jpg';
    $socialUser->token = 'mock-token';
    $socialUser->refreshToken = null;

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andReturn($socialUser);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'google'));

    $this->assertAuthenticatedAs($user);

    $this->assertDatabaseHas('social_accounts', [
        'user_id' => $user->id,
        'provider' => 'google',
        'provider_id' => 'google-id-new-link',
    ]);

    expect($user->fresh()->avatar)->toBe('https://lh3.googleusercontent.com/photo.jpg');

    $response->assertRedirect(route('home'));
});

test('registers and logs in a new user via github callback', function () {
    $socialUser = new SocialiteUser;
    $socialUser->id = 'github-id-998877';
    $socialUser->name = 'GitHub User';
    $socialUser->email = 'github.user@example.com';
    $socialUser->avatar = 'https://avatars.githubusercontent.com/u/12345?v=4';
    $socialUser->token = 'mock-github-token';
    $socialUser->refreshToken = null;

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andReturn($socialUser);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'github'));

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'GitHub User',
        'email' => 'github.user@example.com',
    ]);

    $this->assertDatabaseHas('social_accounts', [
        'provider' => 'github',
        'provider_id' => 'github-id-998877',
    ]);

    $response->assertRedirect(route('home'));
});

test('recovers from invalid state exception by attempting stateless auth', function () {
    $socialUser = new SocialiteUser;
    $socialUser->id = 'github-stateless-123';
    $socialUser->name = 'Stateless User';
    $socialUser->email = 'stateless@example.com';
    $socialUser->avatar = null;
    $socialUser->token = 'token';
    $socialUser->refreshToken = null;

    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andThrow(new InvalidStateException('Invalid state'));

    $statelessProvider = Mockery::mock(GoogleProvider::class);
    $statelessProvider->shouldReceive('user')
        ->once()
        ->andReturn($socialUser);

    $provider->shouldReceive('stateless')
        ->once()
        ->andReturn($statelessProvider);

    Socialite::shouldReceive('driver')
        ->with('github')
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'github'));

    $this->assertAuthenticated();
    $response->assertRedirect(route('home'));
});

test('handles google callback failure gracefully', function () {
    $provider = Mockery::mock(GoogleProvider::class);
    $provider->shouldReceive('user')
        ->once()
        ->andThrow(new Exception('Access denied by user'));

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn($provider);

    $response = $this->get(route('social.callback', 'google'));

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors(['social']);
    $this->assertGuest();
});

test('rejects unsupported oauth provider with 404', function () {
    $response = $this->get('/auth/unsupported-provider/redirect');

    $response->assertNotFound();
});

test('login and register pages render social sign in links', function () {
    $googleRedirectUrl = route('social.redirect', 'google');
    $githubRedirectUrl = route('social.redirect', 'github');

    $loginResponse = $this->get(route('login'));
    $loginResponse->assertOk();
    $loginResponse->assertSee($googleRedirectUrl);
    $loginResponse->assertSee($githubRedirectUrl);

    $registerResponse = $this->get(route('register'));
    $registerResponse->assertOk();
    $registerResponse->assertSee($googleRedirectUrl);
    $registerResponse->assertSee($githubRedirectUrl);
});
