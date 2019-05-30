<?php

namespace Deviate\Usergroups\Normalizers;

use Deviate\Shared\Search\AbstractSearchNormalizer;

class UsergroupSearchNormalizer extends AbstractSearchNormalizer
{
    protected function map(): array
    {
        return [
            'organisation' => 'organisation_id',
            'name'         => 'name',
            'supergroup'   => 'is_supergroup',
            'created'      => 'created_at',
            'updated'      => 'updated_at',
        ];
    }

    protected function whitelist(): array
    {
        return ['organisation', 'name', 'supergroup', 'created', 'updated'];
    }
}
