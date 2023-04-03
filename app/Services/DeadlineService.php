<?php

namespace App\Services;

use App\ThirdParty\FPL\ApiInterface;
use Carbon\Carbon;
use http\Exception\RuntimeException;

class DeadlineService
{
    public function __construct(private readonly ApiInterface $api)
    {
    }

    public function getDeadlineTime(): string
    {
        $result = $this->api->createRequest('bootstrap-static/');

        $currentGameweek = array_filter($result['events'], function ($array) {
            return isset($array['is_current']) && $array['is_current'] === true;
        });

        $currentGameweek = reset($currentGameweek);

        $nextGameweek = array_filter($result['events'], function ($array) {
            return isset($array['is_next']) && $array['is_next'] === true;
        });

        $nextGameweek = reset($nextGameweek);

        $timestamp = $currentGameweek['finished'] ? $nextGameweek['deadline_time'] : $currentGameweek['deadline_time'];

        $date = $this->verifyCarbon(Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $timestamp, 'UTC'));

        $timezoneDate = $this->verifyCarbon($date->tz('Europe/London'));

        return $timezoneDate->format('Y-m-d H:i:s');
    }

    public function hasDeadlinePassed(string $deadlineTime): bool
    {
        $now = $this->verifyCarbon(Carbon::now('Europe/London'));
        $deadline = $this->verifyCarbon(Carbon::createFromFormat('Y-m-d H:i:s', $deadlineTime));

        $nowFormatted = $now->format('U');
        $deadlineFormatted = $deadline->format('U');

        return $deadlineFormatted < $nowFormatted;
    }

    private function verifyCarbon(Carbon|false|String $instance): Carbon
    {
        if (!$instance instanceof Carbon) {
            throw new RuntimeException('Date could not be parsed');
        }

        return $instance;
    }
}
