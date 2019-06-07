<?php

namespace Deviate\Gateway\Shared\Controllers;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function document($transformer, ApiResponseInterface ...$responses): JsonResponse
    {
        $data = (new $transformer(...$responses))->transform();

        return new JsonResponse($data->toArray());
    }
}
