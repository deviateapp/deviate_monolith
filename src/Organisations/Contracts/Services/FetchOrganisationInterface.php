<?php

namespace Deviate\Organisations\Contracts\Services;

use Deviate\Shared\Search\SearchContainerInterface;

interface FetchOrganisationInterface
{
    public function fetchById(string $id): ?array;
    public function search(SearchContainerInterface $search): array;
}
