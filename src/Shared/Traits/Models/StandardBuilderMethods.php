<?php

namespace Deviate\Shared\Traits\Models;

use Deviate\Shared\Traits\ConvertsHashIds;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait StandardBuilderMethods
{
    use ConvertsHashIds;

    public function create(array $attributes = [])
    {
        return parent::create($this->decodeIdsInArray($attributes));
    }

    public function update(array $values)
    {
        return parent::update($this->decodeIdsInArray($values));
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (is_array($column)) {
            $column = $this->decodeIdsInArray($column);
        } elseif ($this->keyLooksLikeIdField($column)) {
            $value    = $this->decode($value);
            $operator = $this->decode($operator);
        }

        return parent::where($column, $operator, $value, $boolean);
    }

    public function findOrFail($id, $columns = ['*']): Model
    {
        try {
            return parent::findOrFail($this->decode($id), $columns);
        } catch (ModelNotFoundException $exception) {
            $this->throwNotFoundException($exception);
        }
    }

    public function firstOrFail($columns = ['*']): Model
    {
        try {
            return parent::firstOrFail($columns);
        } catch (ModelNotFoundException $exception) {
            $this->throwNotFoundException($exception);
        }
    }
}
