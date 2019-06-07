<?php

namespace Deviate\Gateway\Shared\JsonObjects\Schemas;

use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipCollection;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

abstract class AbstractSchema implements SchemaInterface
{
    protected $response;
    protected $type = 'unknown';

    public function __construct(ApiResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response->get('id');
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function defaultRelationships(): RelationshipCollection
    {
        return new RelationshipCollection;
    }
}
