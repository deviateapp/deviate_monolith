<?php

namespace Deviate\Usergroups\Models\Eloquent;

use Deviate\Usergroups\Models\Eloquent\Builders\PermissionBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property int $permission_section_id
 * @property string $permission_key
 * @property string $name
 * @property string $description
 * @property bool $is_ownable
 */
class Permission extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'is_ownable' => 'bool',
    ];

    public function newEloquentBuilder($query)
    {
        return new PermissionBuilder($query);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PermissionSection::class);
    }

    public function usergroup(): BelongsToMany
    {
        return $this->belongsToMany(Usergroup::class)
            ->withPivot('must_own_resource');
    }
}
