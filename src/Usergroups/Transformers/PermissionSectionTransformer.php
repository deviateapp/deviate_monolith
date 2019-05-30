<?php

namespace Deviate\Usergroups\Transformers;

use Deviate\Shared\Transformers\TransformerInterface;
use Deviate\Shared\Transformers\TransformsCollections;
use Illuminate\Database\Eloquent\Model;

class PermissionSectionTransformer implements TransformerInterface
{
    use TransformsCollections;

    private $permissionTransformer;

    public function __construct(PermissionTransformer $permissionTransformer)
    {
        $this->permissionTransformer = $permissionTransformer;
    }

    public function transform(Model $section): array
    {
        /** @var \Deviate\Usergroups\Models\Eloquent\PermissionSection $section */
        return [
            'section'     => $section->name,
            'description' => $section->description,
            'permissions' => $this->permissionTransformer->transformCollection($section->permissions),
        ];
    }
}
