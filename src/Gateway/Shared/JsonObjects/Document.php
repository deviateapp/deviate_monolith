<?php

namespace Deviate\Gateway\Shared\JsonObjects;

class Document
{
    private $resource;
    private $includes;
    private $meta = [];
    private $links = [];

    public function __construct($resource = null)
    {
        $this->resource = $resource;
        $this->includes = new ResourceCollection;
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
        if (is_array($key)) {
            $this->meta = array_merge($this->meta, $key);
        } else {
            $this->meta[$key] = $value;
        }

        return $this;
    }

    public function addLink($key, $value = null)
    {
        if (is_array($key)) {
            $this->links = array_merge($this->links, $key);
        } else {
            $this->links[$key] = $value;
        }

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
            'links'    => $this->links,
            'data'     => $this->resource ? $this->resource->toArray() : [],
            'includes' => $this->getIncludes()->toArray(),
            'meta'     => $this->meta,
        ];
    }
}
