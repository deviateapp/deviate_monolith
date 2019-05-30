<?php

namespace Deviate\Shared\Traits;

use Hashids\HashidsInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use function is_string;

trait ConvertsHashIds
{
    public function encode(int $id)
    {
        return $this->getHashIdsFactory()->encode($id) ?? $id;
    }

    public function decode(?string $id)
    {
        return Arr::first($this->getHashIdsFactory()->decode($id)) ?? $id;
    }

    public function decodeIdsInArray(array $data): array
    {
        return $this->runIdTransformation($data, 'decode');
    }

    public function encodeIdsInArray(array $data): array
    {
        return $this->runIdTransformation($data, 'encode');
    }

    private function keyLooksLikeIdField($key)
    {
        return is_string($key) && Str::endsWith($key, 'id');
    }

    private function runIdTransformation(array $data, string $direction)
    {
        return collect($data)->mapWithKeys(function ($value, $key) use ($direction) {
            return [$key => $this->keyLooksLikeIdField($key) ? $this->{$direction}($value) : $value];
        })->toArray();
    }

    private function getHashIdsFactory(): HashidsInterface
    {
        return app(HashidsInterface::class);
    }
}
