<?php

namespace Deviate\Activities\Models\Eloquent\Builders;

use Deviate\Shared\Traits\Models\StandardBuilderMethods;
use Illuminate\Database\Eloquent\Builder;

class ActivityUserBuilder extends Builder
{
    use StandardBuilderMethods;

    public function for(int $userId, int $activityId): Builder
    {
        return $this->where([
            'user_id'     => $userId,
            'activity_id' => $activityId,
        ]);
    }
}
