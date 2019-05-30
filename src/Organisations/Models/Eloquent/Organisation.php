<?php

namespace Deviate\Organisations\Models\Eloquent;

use Deviate\Organisations\Models\Eloquent\Builders\OrganisationBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $slug
 */
class Organisation extends Model
{
    /** @var array */
    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new OrganisationBuilder($query);
    }
}
