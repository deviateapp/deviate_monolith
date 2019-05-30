<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class ActivityNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The activity could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 4004;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Activity not found';
    }
}
