<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyBookedOnActivityException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('This user is already booked on the activity.');
    }

    protected function getInternalCode(): int
    {
        return 4007;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    protected function getTitle(): string
    {
        return 'User already booked';
    }
}
