<?php

namespace App\ThirdParty\FPL;

interface ApiInterface
{
    /**
     * @return mixed[]
     */
    public function createRequest(string $endpoint): array;
}
