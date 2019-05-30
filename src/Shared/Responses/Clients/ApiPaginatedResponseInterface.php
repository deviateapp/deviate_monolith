<?php

namespace Deviate\Shared\Responses\Clients;

interface ApiPaginatedResponseInterface extends ApiResponseInterface
{
    public function results(): array;
    public function totalRecords(): int;
    public function currentPage(): int;
    public function perPage(): int;
    public function totalPages(): int;
}
