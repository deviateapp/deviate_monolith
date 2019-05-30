<?php

namespace Deviate\Activities\Models\Eloquent;

use Deviate\Activities\Models\Eloquent\Builders\InvitationBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    /** @var string */
    protected $table = 'activity_user';

    /** @var null */
    protected $primaryKey = null;

    /** @var array */
    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new InvitationBuilder($query);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('invited', function (Builder $builder) {
            $builder->where('status', 'invited');
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
