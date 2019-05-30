<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class NewActivityCollectionValidationException extends AbstractApiException
{
    public function __construct(MessageBag $errors)
    {
        parent::__construct('There was an error while trying to create this new activity collection');

        $this->errors = $errors->toArray();
    }

    protected function getInternalCode(): int
    {
        return 4002;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    protected function getTitle(): string
    {
        return 'Validation error';
    }
}
