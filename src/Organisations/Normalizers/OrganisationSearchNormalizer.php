<?php

namespace Deviate\Organisations\Normalizers;

use Deviate\Shared\Search\AbstractSearchNormalizer;

class OrganisationSearchNormalizer extends AbstractSearchNormalizer
{
    protected function map(): array
    {
        return [
            'name'      => 'name',
            'subdomain' => 'slug',
            'created'   => 'created_at',
            'updated'   => 'updated_at',
        ];
    }

    protected function whitelist(): array
    {
        return ['name', 'subdomain', 'created', 'updated'];
    }
}
