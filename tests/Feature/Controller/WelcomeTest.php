<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the welcome page with deadline information', function () {
    $response = $this->get('/');
    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
        ->where('canLogin', true)
        ->where('canRegister', true)
        ->where('missedDeadline', true)
        ->where('deadlineTime', '2023-01-01 01:01:01')
    );
});
