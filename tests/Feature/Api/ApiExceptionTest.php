<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated api request returns proper 401 json error without redirects', function () {
    // Calling without Accept: application/json header to test shouldRenderJsonWhen
    $response = $this->get('/api/profile');

    $response->assertStatus(401);
    $response->assertJson([
        'message' => 'Unauthenticated.',
    ]);
});

test('non-existent api endpoint returns proper 404 json error', function () {
    $response = $this->get('/api/non-existent-endpoint');

    $response->assertStatus(404);
    $response->assertJson([
        'message' => 'The requested API endpoint was not found.',
    ]);
});

test('unsupported http method returns proper 405 json error', function () {
    // GET request to POST /api/register
    $response = $this->get('/api/register');

    $response->assertStatus(405);
    $response->assertJson([
        'message' => 'The HTTP method is not allowed for this API endpoint.',
    ]);
});

test('api validation returns 422 json with friendly custom messages', function () {
    $response = $this->postJson('/api/register', []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'name' => 'The full name field is required.',
        'email' => 'The email address field is required.',
        'password' => 'The password field is required.',
    ]);
});
