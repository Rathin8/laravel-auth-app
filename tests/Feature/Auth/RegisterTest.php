<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertSuccessful();
    $response->assertSee('Create your account');
});

test('new users can register with valid credentials', function () {
    $response = $this->post('/register', [
        'name' => 'Alice Walker',
        'email' => 'alice@example.com',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'terms' => '1',
    ]);

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'Alice Walker',
        'email' => 'alice@example.com',
    ]);

    $user = User::where('email', 'alice@example.com')->first();
    expect($user->terms_accepted_at)->not->toBeNull();

    $response->assertRedirect(route('home'));
});

test('registration requires all mandatory fields', function () {
    $response = $this->post('/register', []);

    $response->assertSessionHasErrors(['name', 'email', 'password', 'terms']);
});

test('registration fails with mismatched passwords', function () {
    $response = $this->post('/register', [
        'name' => 'Bob Builder',
        'email' => 'bob@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'DifferentPassword123!',
        'terms' => '1',
    ]);

    $response->assertSessionHasErrors(['password']);
    $this->assertGuest();
});

test('registration fails when email is already taken', function () {
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $response = $this->post('/register', [
        'name' => 'New User',
        'email' => 'existing@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'terms' => '1',
    ]);

    $response->assertSessionHasErrors(['email']);
    $this->assertGuest();
});

test('registration screen renders terms of service and privacy policy modal with required acceptance options', function () {
    $response = $this->get('/register');

    $response->assertSuccessful();

    // Verify outer checkbox and triggers
    $response->assertSee('id="terms"', false);
    $response->assertSee('id="openTermsLink"', false);
    $response->assertSee('id="openPrivacyLink"', false);
    $response->assertDontSee('review-legal-badge');

    // Verify modal container and accessibility attributes
    $response->assertSee('id="legalModalBackdrop"', false);
    $response->assertSee('role="dialog"', false);
    $response->assertSee('aria-modal="true"', false);
    $response->assertSee('id="legalModalTitle"', false);
    $response->assertSee('id="closeLegalModal"', false);

    // Verify modal body sections
    $response->assertSee('id="termsSection"', false);
    $response->assertSee('id="privacySection"', false);

    // Verify both acceptance checkbox options inside the modal
    $response->assertSee('id="modalAgreeTerms"', false);
    $response->assertSee('id="modalAgreePrivacy"', false);
    $response->assertSee('id="closeLegalModalBtn"', false);
    $response->assertSee('id="confirmLegalBtn"', false);
});

test('registration screen includes responsive styles and sleek scrollbar for legal modal', function () {
    $response = $this->get('/register');

    $response->assertSuccessful();

    // Responsive tiers for legal modal
    $response->assertSee('@media (min-width: 1025px)', false);
    $response->assertSee('@media (min-width: 641px) and (max-width: 1024px)', false);
    $response->assertSee('@media (max-width: 640px)', false);
    $response->assertSee('.legal-modal-dialog', false);
    $response->assertSee('.legal-modal-body', false);

    // Desktop sleek scrollbar design for modal
    $response->assertSee('.legal-modal-body::-webkit-scrollbar', false);
    $response->assertSee('.legal-modal-body::-webkit-scrollbar-thumb', false);
});
