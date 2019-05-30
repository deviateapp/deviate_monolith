<?php

namespace Deviate\Shared\Responses;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Support\Traits\Macroable;

abstract class AbstractApiResponse implements ApiResponseInterface
{
    use Macroable;

    public function rethrow(): ApiResponseInterface
    {
        return $this;
    }
}
