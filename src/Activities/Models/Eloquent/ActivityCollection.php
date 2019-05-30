<?php

namespace Deviate\Activities\Models\Eloquent;

use Deviate\Activities\Models\Eloquent\Builders\ActivityCollectionBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property int $organisation_id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $booking_starts_at
 * @property \Carbon\Carbon $booking_ends_at
 * @property \Carbon\Carbon $payment_starts_at
 * @property \Carbon\Carbon $payment_ends_at
 * @property \Carbon\Carbon $activities_start_at
 * @property \Carbon\Carbon $activities_end_at
 */
class ActivityCollection extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $dates = [
        'created_at',
        'updated_at',
        'booking_starts_at',
        'booking_ends_at',
        'payment_starts_at',
        'payment_ends_at',
        'activities_start_at',
        'activities_end_at',
    ];

    public function newEloquentBuilder($query)
    {
        return new ActivityCollectionBuilder($query);
    }
}
