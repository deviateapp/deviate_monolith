<?php

namespace Deviate\Usergroups\Services;

use Deviate\Usergroups\Contracts\Repositories\DeleteUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\DeleteUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\MembershipInterface;

class DeleteUsergroup implements DeleteUsergroupInterface
{
    /** @var DeleteUsergroupsRepositoryInterface */
    private $deletesUsergroups;

    /** @var MembershipInterface */
    private $membership;

    public function __construct(DeleteUsergroupsRepositoryInterface $deletesUsergroups, MembershipInterface $membership)
    {
        $this->deletesUsergroups = $deletesUsergroups;
        $this->membership        = $membership;
    }

    public function deleteById(int $id): void
    {
        $this->membership->removeByUsergroupId($id);

        $this->deletesUsergroups->deleteUsergroupById($id);
    }
}
