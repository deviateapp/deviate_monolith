<?php

namespace Deviate\Users\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The requested user could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 2002;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'User not found';
    }
}
