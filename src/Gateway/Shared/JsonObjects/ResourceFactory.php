<?php

namespace Deviate\Gateway\Shared\JsonObjects;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class ResourceFactory
{
    private static $schemas = [];

    public static function registerSchema(string $type, string $schema)
    {
        self::$schemas[$type] = $schema;
    }

    public static function registerSchemas(array $schemas)
    {
        self::$schemas = array_merge(self::$schemas, $schemas);
    }

    public static function make($type, ?ApiResponseInterface $response = null)
    {
        $factory = new static;

        if (is_null($response)) {
            return $factory->makeFromArray($type);
        } else {
            return $factory->makeSingle($type, $response);
        }
    }

    public function makeFromArray(array $make)
    {
        return array_map(function ($type, ApiResponseInterface $response) {
            return $this->makeSingle($type, $response);
        }, array_keys($make), $make);
    }

    public function makeSingle($type, ApiResponseInterface $response)
    {
        return new Resource(new self::$schemas[$type]($response));
    }
}
