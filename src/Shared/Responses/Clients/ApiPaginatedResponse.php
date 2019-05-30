<?php

namespace Deviate\Shared\Responses\Clients;

class ApiPaginatedResponse extends ApiResponse implements ApiPaginatedResponseInterface
{
    public function results(): array
    {
        return $this->get('data', []);
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
        return 1;
    }

    public function perPage(): int
    {
        return 1;
    }
}
