<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class ActivityCollectionNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The activity collection could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 4001;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Activity collection not found';
    }
}
