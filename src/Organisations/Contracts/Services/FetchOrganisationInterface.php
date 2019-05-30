<?php

namespace Deviate\Organisations\Contracts\Services;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchOrganisationInterface
{
    public function fetchById(int $id): ?array;
    public function search(SearchContainerInterface $search): array;
}
