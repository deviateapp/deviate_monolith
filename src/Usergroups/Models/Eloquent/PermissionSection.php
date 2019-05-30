<?php

namespace Deviate\Usergroups\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read \Carbon\Carbon $created_at
 * @property-read \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $description
 *
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 */
class PermissionSection extends Model
{
    /** @var array */
    protected $guarded = [];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
