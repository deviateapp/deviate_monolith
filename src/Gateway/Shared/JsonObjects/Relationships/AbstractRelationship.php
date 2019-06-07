<?php

namespace Deviate\Gateway\Shared\JsonObjects\Relationships;

use Deviate\Gateway\Shared\JsonObjects\LinkCollection;

abstract class AbstractRelationship implements RelationshipInterface
{
    private $type;
    private $ids;
    private $links;

    public function __construct(string $type, $ids, ?LinkCollection $links = null)
    {
        $this->type  = $type;
        $this->ids   = $ids;
        $this->links = $links ?? new LinkCollection;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function toArray()
    {
        return [
            'data'  => $this->isSingular()
                ? ['type' => $this->type, 'id' => (int) $this->ids]
                : array_map(function ($id) {
                    return ['type' => $this->type, 'id' => (int) $id];
                }, $this->ids),
            'links' => $this->links->toArray(),
        ];
    }

    abstract protected function isSingular(): bool;
}
