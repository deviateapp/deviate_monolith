<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class InvitationNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The invitation could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 4012;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Invitation not found';
    }
}
