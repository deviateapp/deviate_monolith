<?php

namespace Deviate\Activities\Contracts\Services\Activities;

interface CreateActivityInterface
{
    public function createSingleActivity(array $data): array;
}
