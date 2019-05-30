<?php

namespace Deviate\Users\Models\Eloquent;

use Deviate\Users\Models\Eloquent\Builders\AvatarBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $path
 */
class Avatar extends Model
{
    use SoftDeletes;

    /** @var array */
    protected $guarded = [];

    public function newEloquentBuilder($query)
    {
        return new AvatarBuilder($query);
    }
}
