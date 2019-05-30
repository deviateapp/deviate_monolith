<?php

namespace Deviate\Shared\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait StandardBuilderMethods
{
    public function findOrFail($id, $columns = ['*']): Model
    {
        try {
            return parent::findOrFail($id, $columns);
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
