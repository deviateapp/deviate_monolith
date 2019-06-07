<?php

namespace Deviate\Gateway\Shared\JsonObjects;

class LinkCollection
{
    private $links = [];

    public function add($type, $url = null)
    {
        if (is_array($type)) {
            $this->links = array_merge($this->links, $type);
        } else {
            $this->links[$type] = $url;
        }

        return $this;
    }

    public function toArray()
    {
        return $this->links;
    }
}
