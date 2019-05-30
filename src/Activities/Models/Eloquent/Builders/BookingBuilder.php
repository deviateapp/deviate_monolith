<?php

namespace Deviate\Activities\Models\Eloquent\Builders;

use Deviate\Activities\Exceptions\BookingNotFoundException;
use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class BookingBuilder extends Builder
{
    use StandardBuilderMethods;

    public function create(array $attributes = [])
    {
        return parent::create(
            Arr::only($attributes, ['activity_id', 'user_id']) + ['status' => 'booked']
        );
    }

    public function activityOverlaps(array $activity): Builder
    {
        $start = sprintf('%s 00:00:00', $activity['starts_at']);
        $end   = sprintf('%s 23:59:59', $activity['ends_at']);

        return $this->whereHas('activity', function (Builder $query) use ($start, $end) {
            $query->whereBetween('starts_at', [$start, $end])
                ->orWhereBetween('ends_at', [$start, $end])
                ->orWhere(function (Builder $query) use ($start, $end) {
                    $query->where('starts_at', '<=', $start)
                        ->where('ends_at', '>=', $end);
                });
        });
    }

    protected function throwNotFoundException(ModelNotFoundException $exception)
    {
        throw new BookingNotFoundException;
    }
}
