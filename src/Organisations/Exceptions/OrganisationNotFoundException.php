<?php

namespace Deviate\Organisations\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class OrganisationNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The organisation could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 1001;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Organisation not found';
    }
}
