<?php

use App\ThirdParty\FPL\ApiInterface;
use Illuminate\Support\Facades\App;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the welcome page with deadline information', function () {
    $apiMock = Mockery::mock(ApiInterface::class);
    $apiMock
        ->shouldReceive('createRequest')
        ->andReturn([
            'events' => [
                [
                    'is_current'    => true,
                    'deadline_time' => '2023-03-03T01:01:01Z',
                    'finished'      => false
                ],
                [
                    'is_next'    => true,
                    'deadline_time' => '2023-03-10T01:01:01Z',
                    'finished'      => false
                ]
            ]
        ]);

    App::instance(ApiInterface::class, $apiMock);

    $response = $this->get('/');
    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
        ->where('canLogin', true)
        ->where('canRegister', true)
        ->where('missedDeadline', true)
        ->where('deadlineTime', '2023-03-03 01:01:01')
    );
});
