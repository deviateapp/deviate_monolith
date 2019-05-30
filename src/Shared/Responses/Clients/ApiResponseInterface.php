<?php

namespace Deviate\Shared\Responses\Clients;

use Illuminate\Contracts\Support\Arrayable;

interface ApiResponseInterface extends Arrayable
{
    public function isSuccessful(): bool;
    public function rethrow(): ApiResponseInterface;
    public function get(string $key, $default = null);
    public function only(array $keys): array;
    public function except(array $keys): array;
}
