<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class CannotBookInviteOnlyActivityException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('Cannot book this invite only activity without an invitation');
    }

    protected function getInternalCode(): int
    {
        return 4010;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_CONFLICT;
    }

    protected function getTitle(): string
    {
        return 'Cannot book activity';
    }
}
