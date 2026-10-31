<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class SocialAuthController extends Controller
{
    /**
     * Supported OAuth providers.
     *
     * @var list<string>
     */
    protected const SUPPORTED_PROVIDERS = [
        'google',
        'github',
    ];

    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->ensureProviderIsSupported($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider and authenticate.
     */
    public function callback(string $provider, Request $request): RedirectResponse
    {
        $this->ensureProviderIsSupported($provider);

        try {
            /** @var \Laravel\Socialite\Two\User $socialUser */
            $socialUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            // Local environments frequently experience domain/cookie mismatches (e.g. localhost vs 127.0.0.1)
            try {
                /** @var \Laravel\Socialite\Two\User $socialUser */
                $socialUser = Socialite::driver($provider)->stateless()->user();
            } catch (Throwable $innerException) {
                Log::error("OAuth authentication error [{$provider}] (stateless): ".$innerException->getMessage(), [
                    'exception' => $innerException,
                ]);

                $errorMessage = app()->isLocal()
                    ? 'Unable to authenticate with '.ucfirst($provider).': '.$innerException->getMessage()
                    : 'Unable to authenticate with '.ucfirst($provider).'. Please try again.';

                return redirect()->route('login')->withErrors([
                    'social' => $errorMessage,
                ]);
            }
        } catch (Throwable $e) {
            Log::error("OAuth authentication error [{$provider}]: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            $errorMessage = app()->isLocal()
                ? 'Unable to authenticate with '.ucfirst($provider).': '.$e->getMessage()
                : 'Unable to authenticate with '.ucfirst($provider).'. Please try again.';

            return redirect()->route('login')->withErrors([
                'social' => $errorMessage,
            ]);
        }

        $email = $socialUser->getEmail();

        if (! $email) {
            return redirect()->route('login')->withErrors([
                'social' => 'No email address received from '.ucfirst($provider).'. Please ensure your account has a public/verified email.',
            ]);
        }

        // 1. Check if this social account is already linked
        $socialAccount = SocialAccount::query()
            ->where('provider', $provider)
            ->where('provider_id', (string) $socialUser->getId())
            ->first();

        if ($socialAccount) {
            $user = $socialAccount->user;

            $socialAccount->update([
                'avatar' => $socialUser->getAvatar(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
            ]);
        } else {
            // 2. Find or create the user with this email
            $user = User::query()->where('email', $email)->first();

            if (! $user) {
                $name = $socialUser->getName() ?: ($socialUser->getNickname() ?: 'User');

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'avatar' => $socialUser->getAvatar(),
                ]);

                event(new Registered($user));
            } elseif (! $user->avatar && $socialUser->getAvatar()) {
                $user->update([
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            // 3. Link this social account to the user
            $user->socialAccounts()->create([
                'provider' => $provider,
                'provider_id' => (string) $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
            ]);
        }

        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('status', 'Welcome, '.$user->name.'!');
    }

    /**
     * Validate whether the provider is supported.
     */
    protected function ensureProviderIsSupported(string $provider): void
    {
        abort_unless(in_array($provider, self::SUPPORTED_PROVIDERS, true), 404);
    }
}
