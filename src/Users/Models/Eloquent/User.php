<?php

namespace Deviate\Users\Models\Eloquent;

use Deviate\Users\Models\Eloquent\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property int $organisation_id
 * @property string $forename
 * @property string $surname
 * @property string $email
 * @property string $password
 *
 * @property Avatar $avatar
 */
class User extends Authenticatable
{
    use Notifiable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /** @var array */
    protected $dates = ['deleted_at'];

    /** @var array */
    protected $with = ['avatar'];

    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }

    public function avatar(): HasMany
    {
        return $this->hasMany(Avatar::class);
    }
}
