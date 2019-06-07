<?php

namespace Deviate\Gateway\Shared\JsonObjects;

class MetaCollection
{
    private $data = [];

    public function add($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }
}
