<?php

namespace Deviate\Shared\Clients;

use Deviate\Shared\Exceptions\AbstractApiException;
use Deviate\Shared\Responses\Clients\ApiErrorResponse;
use Deviate\Shared\Responses\Clients\ApiResponse;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;
use Illuminate\Contracts\Events\Dispatcher;

abstract class AbstractClient
{
    /** @var Dispatcher */
    private $events;

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    protected function call(string $event, array $payload = []): ApiResponseInterface
    {
        try {
            $response = $this->events->dispatch($event, [
                'payload' => $payload,
            ], true);

            return $this->toApiResponse($response);
        } catch (AbstractApiException $exception) {
            return $this->toApiErrorResponse($exception);
        }
    }

    protected function toApiResponse(?array $response): ApiResponseInterface
    {
        return new ApiResponse($response);
    }

    protected function toApiErrorResponse(AbstractApiException $exception)
    {
        return new ApiErrorResponse($exception);
    }
}
