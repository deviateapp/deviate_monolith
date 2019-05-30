<?php

namespace Deviate\Usergroups\Services;

use Deviate\Usergroups\Contracts\Repositories\CreateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\CreateUsergroupInterface;
use Deviate\Usergroups\Validators\NewUsergroupValidator;

class CreateUsergroup implements CreateUsergroupInterface
{
    /** @var CreateUsergroupsRepositoryInterface */
    private $createsUsergroups;

    /** @var FetchUsergroupsRepositoryInterface */
    private $fetchesUsergroups;

    /** @var NewUsergroupValidator */
    private $validator;

    public function __construct(
        CreateUsergroupsRepositoryInterface $createsUsergroups,
        FetchUsergroupsRepositoryInterface $fetchesUsergroups,
        NewUsergroupValidator $validator
    ) {
        $this->createsUsergroups = $createsUsergroups;
        $this->fetchesUsergroups = $fetchesUsergroups;
        $this->validator         = $validator;
    }

    public function createSingleUsergroup(array $data): array
    {
        $this->validator->validate([
            'organisation_id' => $data['organisation_id'] ?? null,
            'name'            => $data['name'] ?? null,
            'description'     => $data['description'] ?? null,
            'is_supergroup'   => $data['is_supergroup'] ?? false,
        ]);

        $id = $this->createsUsergroups->createUsergroup($data);

        return $this->fetchesUsergroups->fetchById($id);
    }
}
