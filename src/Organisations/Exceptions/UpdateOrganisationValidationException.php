<?php

namespace Deviate\Organisations\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class UpdateOrganisationValidationException extends AbstractApiException
{
    public function __construct(MessageBag $errors)
    {
        parent::__construct('There was an error with the supplied data when attempting to update the organisation');

        $this->errors = $errors->toArray();
    }

    protected function getInternalCode(): int
    {
        return 1003;
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
