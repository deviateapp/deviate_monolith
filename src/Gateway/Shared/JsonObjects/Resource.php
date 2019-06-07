<?php

namespace Deviate\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipCollection;
use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipInterface;
use Deviate\Gateway\Shared\JsonObjects\Schemas\SchemaInterface;

class Resource implements ResourceInterface
{
    private $schema;
    private $links;
    private $meta;
    private $relationships;

    public function __construct(SchemaInterface $schema)
    {
        $this->schema        = $schema;
        $this->links         = new LinkCollection;
        $this->meta          = new MetaCollection;
        $this->relationships = $schema->defaultRelationships();
    }

    public function addLink($type, $url = null): ResourceInterface
    {
        $this->links->add($type, $url);

        return $this;
    }

    public function addMeta($key, $value = null): ResourceInterface
    {
        $this->meta->add($key, $value);

        return $this;
    }

    public function addRelationship(RelationshipInterface $relationship): ResourceInterface
    {
        $this->relationships->push($relationship);

        return $this;
    }

    public function toArray()
    {
        return [
            'type'          => $this->schema->getType(),
            'id'            => $this->schema->getId(),
            'attributes'    => $this->schema->toArray(),
            'links'         => $this->links->toArray(),
            'relationships' => $this->relationships->toArray(),
            'meta'          => $this->meta->toArray(),
        ];
    }
}
