<?php

namespace Deviate\Activities\Contracts\Services\Activities;

interface DeleteActivityInterface
{
    public function deleteById(int $activityId): void;
}
