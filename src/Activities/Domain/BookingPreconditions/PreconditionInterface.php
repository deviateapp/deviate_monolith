<?php

namespace Deviate\Activities\Domain\BookingPreconditions;

interface PreconditionInterface
{
    public function check(string $userId, string $activityId, bool $force = false): void;
    public function throwException(): void;
}
