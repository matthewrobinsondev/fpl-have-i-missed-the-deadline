<?php

namespace App\Services;

class DeadlineService
{
    public function getDeadlineTime(): string
    {
        // Logic to calculate deadline time
        return '2023-01-01 01:01:01';
    }

    public function hasDeadlinePassed(string $deadlineTime): bool
    {
        // Logic to check if deadline has passed
        return true;
    }
}
