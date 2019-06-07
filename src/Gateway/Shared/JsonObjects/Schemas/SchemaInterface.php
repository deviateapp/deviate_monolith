<?php

namespace Deviate\Gateway\Shared\JsonObjects\Schemas;

use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipCollection;
use Illuminate\Contracts\Support\Arrayable;

interface SchemaInterface extends Arrayable
{
    public function getId();
    public function getType(): string;
    public function defaultRelationships(): RelationshipCollection;
}
