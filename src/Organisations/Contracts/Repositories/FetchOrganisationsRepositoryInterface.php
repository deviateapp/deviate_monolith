<?php

namespace Deviate\Organisations\Contracts\Repositories;

use Deviate\Shared\Repositories\SearchableRepositoryInterface;

interface FetchOrganisationsRepositoryInterface extends SearchableRepositoryInterface
{
    public function fetchByDetails(array $details): array;
    public function fetchOrganisationById(int $id): array;
    public function isSlugRegistered(string $slug, ?int $ignoreId = null): bool;
}
