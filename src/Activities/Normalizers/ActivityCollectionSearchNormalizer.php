<?php

namespace Deviate\Activities\Normalizers;

use Deviate\Shared\Search\AbstractSearchNormalizer;

class ActivityCollectionSearchNormalizer extends AbstractSearchNormalizer
{
    protected function map(): array
    {
        return [
            'organisation'     => 'organisation_id',
            'name'             => 'name',
            'booking_starts'   => 'booking_starts_at',
            'payment_starts'   => 'payment_starts_at',
            'activities_start' => 'activities_start_at',
        ];
    }

    protected function whitelist(): array
    {
        return ['organisation', 'name', 'booking_starts', 'payment_starts', 'activities_start'];
    }
}
