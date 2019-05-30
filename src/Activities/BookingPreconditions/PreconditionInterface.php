<?php

namespace Deviate\Activities\BookingPreconditions;

interface PreconditionInterface
{
    public function check(string $userId, string $activityId, bool $force = false): void;
    public function throwException(): void;
}
