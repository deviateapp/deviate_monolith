<?php

namespace Deviate\Usergroups\Transformers;

use Deviate\Shared\Transformers\TransformerInterface;
use Deviate\Shared\Transformers\TransformsCollections;
use Illuminate\Database\Eloquent\Model;

class UsergroupPermissionTransformer implements TransformerInterface
{
    use TransformsCollections;

    public function transform(Model $permission): array
    {
        /** @var \Deviate\Usergroups\Models\Eloquent\Permission $permission */
        return [
            'key'               => $permission->permission_key,
            'name'              => $permission->name,
            'description'       => $permission->description,
            'must_own_resource' => (bool) $permission->pivot_must_own_resource ?? false,
        ];
    }
}
