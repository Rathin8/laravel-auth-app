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
