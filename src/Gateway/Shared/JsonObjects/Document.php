<?php

namespace Deviate\Gateway\Shared\JsonObjects;

class Document
{
    private $resource;
    private $includes;
    private $meta;
    private $links;

    public function __construct($resource = null)
    {
        $this->resource = $resource;
        $this->includes = new ResourceCollection;
        $this->links    = new LinkCollection;
        $this->meta     = new MetaCollection;
    }

    public function addInclude($resource): Document
    {
        if ($resource instanceof Resource) {
            $this->includes->push($resource);
        } elseif ($resource instanceof ResourceCollection) {
            $resource->each(function (Resource $resource) {
                $this->includes->push($resource);
            });
        }

        return $this;
    }

    public function addMeta($key, $value = null)
    {
        $this->meta->add($key, $value);

        return $this;
    }

    public function addLink($key, $value = null)
    {
        $this->links->add($key, $value);

        return $this;
    }

    public function getResource(): ?Resource
    {
        return $this->resource;
    }

    public function getIncludes(): ResourceCollection
    {
        return $this->includes;
    }

    public function toArray()
    {
        return [
            'links'    => $this->links->toArray(),
            'data'     => $this->resource ? $this->resource->toArray() : [],
            'includes' => $this->getIncludes()->toArray(),
            'meta'     => $this->meta->toArray(),
        ];
    }
}
