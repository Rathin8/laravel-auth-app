<?php

test('home view includes responsive viewport and responsive tiers for mobile tablet and desktop', function () {
    $response = $this->get('/home');

    $response->assertOk();
    $response->assertSee('name="viewport" content="width=device-width, initial-scale=1.0"', false);
    $response->assertSee('@media (min-width: 1025px)', false);
    $response->assertSee('@media (min-width: 641px) and (max-width: 1024px)', false);
    $response->assertSee('@media (max-width: 640px)', false);
    $response->assertSee('profile-actions');
});

test('login view includes responsive viewport and responsive tiers for mobile tablet and desktop', function () {
    $response = $this->get('/login');

    $response->assertOk();
    $response->assertSee('name="viewport" content="width=device-width, initial-scale=1"', false);
    $response->assertSee('@media (min-width: 1025px)', false);
    $response->assertSee('@media (min-width: 641px) and (max-width: 1024px)', false);
    $response->assertSee('@media (max-width: 640px)', false);
    $response->assertSee('social-grid');
});

test('register view includes responsive viewport and responsive tiers for mobile tablet and desktop', function () {
    $response = $this->get('/register');

    $response->assertOk();
    $response->assertSee('name="viewport" content="width=device-width, initial-scale=1"', false);
    $response->assertSee('@media (min-width: 1025px)', false);
    $response->assertSee('@media (min-width: 641px) and (max-width: 1024px)', false);
    $response->assertSee('@media (max-width: 640px)', false);
    $response->assertSee('strength-meter-grid');
});
