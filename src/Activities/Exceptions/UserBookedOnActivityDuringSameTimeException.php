<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class UserBookedOnActivityDuringSameTimeException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('This user is already booked on an activity which overlaps with the requested activity.');
    }

    protected function getInternalCode(): int
    {
        return 4008;
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
