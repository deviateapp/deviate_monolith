<?php

namespace Deviate\Activities\Contracts\Services\Activities;

interface UpdateActivityInterface
{
    public function updateById(int $activityId, array $data): array;
}
