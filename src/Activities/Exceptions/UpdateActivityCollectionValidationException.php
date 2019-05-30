<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class UpdateActivityCollectionValidationException extends AbstractApiException
{
    public function __construct(MessageBag $errors)
    {
        parent::__construct('There was an error while trying to update this activity collection');

        $this->errors = $errors->toArray();
    }

    protected function getInternalCode(): int
    {
        return 4003;
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
