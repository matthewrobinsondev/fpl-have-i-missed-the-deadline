<?php

namespace App\Services;

use App\ThirdParty\FPL\ApiInterface;

class TransferService
{
    public function __construct(private readonly ApiInterface $api)
    {
    }

    /**
     * @return mixed[]
     */
    public function getTopTransferedIn(): array
    {
        $result = $this->api->createRequest('bootstrap-static/');

        $players = $result['elements'];
        $extractTransfersInEvent = fn ($arr) => $arr['transfers_in_event'];

        usort($players, function ($sortA, $sortB) {
            return $sortB['transfers_in_event'] <=> $sortA['transfers_in_event'];
        });

        $transfersInEvents = array_map($extractTransfersInEvent, $players);

        $topTransfersInEvents = array_slice($transfersInEvents, 0, 10);

        return array_filter($players, fn ($arr) => in_array(
            $arr['transfers_in_event'],
            $topTransfersInEvents
        ));
    }
}
