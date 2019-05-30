<?php

namespace Deviate\Activities\Models\Eloquent;

use Deviate\Activities\Models\Eloquent\Builders\ActivityBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property int $organisation_id
 * @property int $activity_collection_id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $ends_at
 * @property int $places
 * @property int $cost
 * @property bool $is_hidden
 * @property bool $is_invite_only
 */
class Activity extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $dates = ['created_at', 'updated_at', 'starts_at', 'ends_at'];

    public function newEloquentBuilder($query)
    {
        return new ActivityBuilder($query);
    }
}
