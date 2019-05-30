<?php

namespace Deviate\Usergroups\Models\Eloquent;

use Deviate\Usergroups\Models\Eloquent\Builders\UsergroupBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property int $organisation_id
 * @property string $name
 * @property string $description
 * @property bool $is_supergroup
 */
class Usergroup extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'is_supergroup' => 'bool',
    ];

    public function newEloquentBuilder($query)
    {
        return new UsergroupBuilder($query);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withPivot([
            'must_own_resource',
        ]);
    }
}
