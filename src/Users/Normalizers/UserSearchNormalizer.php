<?php

namespace Deviate\Users\Normalizers;

use Deviate\Shared\Search\AbstractSearchNormalizer;

class UserSearchNormalizer extends AbstractSearchNormalizer
{
    protected function map(): array
    {
        return [
            'id'           => 'id',
            'organisation' => 'organisation_id',
            'forename'     => 'forename',
            'surname'      => 'surname',
            'email'        => 'email',
            'created'      => 'created_at',
            'updated'      => 'updated_at',
        ];
    }

    protected function whitelist(): array
    {
        return ['id', 'organisation', 'forename', 'surname', 'email', 'created', 'updated'];
    }
}
