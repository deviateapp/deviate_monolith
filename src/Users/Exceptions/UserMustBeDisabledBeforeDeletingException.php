<?php

namespace Deviate\Users\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UserMustBeDisabledBeforeDeletingException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The user must be disabled before deleting.');
    }

    protected function getInternalCode(): int
    {
        return 2005;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_CONFLICT;
    }

    protected function getTitle(): string
    {
        return 'User not disabled';
    }
}
