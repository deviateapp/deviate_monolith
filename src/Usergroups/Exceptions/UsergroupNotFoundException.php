<?php

namespace Deviate\Usergroups\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UsergroupNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The usergroup could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 3002;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Usergroup not found';
    }
}
