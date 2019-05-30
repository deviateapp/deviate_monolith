<?php

namespace Deviate\Usergroups\Services;

use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\FetchUsergroupInterface;
use Deviate\Usergroups\Normalizers\UsergroupSearchNormalizer;

class FetchUsergroup implements FetchUsergroupInterface
{
    private $fetchesUsergroups;
    private $normalizer;

    public function __construct(
        FetchUsergroupsRepositoryInterface $fetchesUsergroups,
        UsergroupSearchNormalizer $normalizer
    ) {
        $this->fetchesUsergroups = $fetchesUsergroups;
        $this->normalizer        = $normalizer;
    }

    public function search(SearchContainerInterface $search): array
    {
        return $this->fetchesUsergroups->search($this->normalizer->normalize($search));
    }

    public function fetchById(int $id): array
    {
        return $this->fetchesUsergroups->fetchById($id);
    }
}
