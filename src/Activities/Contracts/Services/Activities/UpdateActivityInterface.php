<?php

namespace Deviate\Activities\Contracts\Services\Activities;

interface UpdateActivityInterface
{
    public function updateById(string $activityId, array $data): array;
}
