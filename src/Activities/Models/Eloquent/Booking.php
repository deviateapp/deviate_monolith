<?php

namespace Deviate\Activities\Models\Eloquent;

use Deviate\Activities\Models\Eloquent\Builders\BookingBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /** @var string */
    protected $table = 'activity_user';

    /** @var null */
    protected $primaryKey = null;

    /** @var array */
    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new BookingBuilder($query);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('booking', function (Builder $builder) {
            $builder->where('status', 'booked');
        });
    }

    /**
     * Booking constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->incrementing = false;

        parent::__construct($attributes);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
