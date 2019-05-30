<?php

namespace Deviate\Shared\Responses\Clients;

class ApiPaginatedErrorResponse extends ApiErrorResponse implements ApiPaginatedResponseInterface
{
    public function results(): array
    {
        return [];
    }

    public function currentPage(): int
    {
        return 1;
    }

    public function totalPages(): int
    {
        return 1;
    }

    public function totalRecords(): int
    {
        return 0;
    }

    public function perPage(): int
    {
        return 1;
    }
}
