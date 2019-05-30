<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Transformers\UsergroupTransformer;

class FetchUsergroupsRepository extends AbstractRepository implements FetchUsergroupsRepositoryInterface
{
    private $usergroup;
    private $transformer;

    public function __construct(Usergroup $usergroup, UsergroupTransformer $transformer)
    {
        $this->usergroup   = $usergroup;
        $this->transformer = $transformer;
    }

    public function search(SearchContainerInterface $search): array
    {
        $paginator = $this->usergroup->newQuery()->search($search);

        return $this->transformer->transformSearch($paginator);
    }

    public function fetchById(string $id): array
    {
        /** @var Usergroup $usergroup */
        $usergroup = $this->usergroup->newQuery()->findOrFail($id);

        return $this->transformer->transform($usergroup);
    }

    public function isNameRegistered(string $organisationId, string $name, ?string $excludeId = null): bool
    {
        $usergroup = $this->usergroup->newQuery()->where('organisation_id', $organisationId)
            ->where('name', $name)
            ->first();

        return $usergroup && (!$excludeId || $excludeId !== $usergroup['id']);
    }
}
