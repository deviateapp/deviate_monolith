<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyInvitedToActivityException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('This user is already invited to the activity.');
    }

    protected function getInternalCode(): int
    {
        return 4009;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    protected function getTitle(): string
    {
        return 'User already invited';
    }
}
