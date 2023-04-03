<?php

use App\Services\TransferService;
use App\ThirdParty\FPL\ApiInterface;

it('renders the welcome page with deadline information', function () {
    $apiMock = Mockery::mock(ApiInterface::class);
    $apiMock
        ->shouldReceive('createRequest')
        ->andReturn([
            'elements' => [
                [
                    'id'                    => 1,
                    'transfers_in_event'    => 555
                ],
                [
                    'id'                    => 2,
                    'transfers_in_event'    => 1000
                ],
                [
                    'id'                    => 3,
                    'transfers_in_event'    => 200
                ],
                [
                    'id'                    => 4,
                    'transfers_in_event'    => 6000
                ],
                [
                    'id'                    => 5,
                    'transfers_in_event'    => 1
                ]
            ]
        ]);

    $transferService = new TransferService($apiMock);
    $topTransfers = $transferService->getTopTransferedIn();

    expect($topTransfers)->toBe([
        [
            'id'                    => 4,
            'transfers_in_event'    => 6000
        ],
        [
            'id'                    => 2,
            'transfers_in_event'    => 1000
        ],
        [
            'id'                    => 1,
            'transfers_in_event'    => 555
        ],
        [
            'id'                    => 3,
            'transfers_in_event'    => 200
        ],
        [
            'id'                    => 5,
            'transfers_in_event'    => 1
        ]
    ]);
});
