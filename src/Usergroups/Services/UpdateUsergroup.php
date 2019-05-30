<?php

namespace Deviate\Usergroups\Services;

use Deviate\Usergroups\Collections\RequestedPermissionsCollection;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\UsergroupPermissionsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\UpdateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\UpdateUsergroupInterface;
use Deviate\Usergroups\Validators\ApplyPermissionsValidator;
use Deviate\Usergroups\Validators\UpdateUsergroupValidator;

class UpdateUsergroup implements UpdateUsergroupInterface
{
    /** @var FetchUsergroupsRepositoryInterface */
    private $fetchesUsergroups;

    /** @var UpdateUsergroupsRepositoryInterface */
    private $updatesUsergroups;

    /** @var UsergroupPermissionsRepositoryInterface */
    private $usergroupPermissions;

    /** @var UpdateUsergroupValidator */
    private $validator;

    /** @var ApplyPermissionsValidator */
    private $applyPermissionsValidator;

    public function __construct(
        FetchUsergroupsRepositoryInterface $fetchesUsergroups,
        UpdateUsergroupsRepositoryInterface $updatesUsergroups,
        UsergroupPermissionsRepositoryInterface $usergroupPermissions,
        UpdateUsergroupValidator $validator,
        ApplyPermissionsValidator $applyPermissionsValidator
    ) {
        $this->fetchesUsergroups         = $fetchesUsergroups;
        $this->updatesUsergroups         = $updatesUsergroups;
        $this->usergroupPermissions      = $usergroupPermissions;
        $this->validator                 = $validator;
        $this->applyPermissionsValidator = $applyPermissionsValidator;
    }

    public function updateByUsergroupId(int $id, array $data): array
    {
        $usergroup = $this->fetchesUsergroups->fetchById($id);

        $this->validator->validate(array_merge($data, [
            'id'              => $id,
            'organisation_id' => $usergroup['organisation_id'],
        ]));

        $this->updatesUsergroups->updateUsergroupById($id, $data);

        return $this->fetchesUsergroups->fetchById($id);
    }

    public function applyPermissions(int $id, array $permissions): void
    {
        $this->applyPermissionsValidator->validate([
            'permissions' => $permissions,
        ]);

        $collection = new RequestedPermissionsCollection($permissions);

        $this->usergroupPermissions->removeAllPermissions($id);
        $this->usergroupPermissions->applyPermissions($id, $collection);
    }
}
