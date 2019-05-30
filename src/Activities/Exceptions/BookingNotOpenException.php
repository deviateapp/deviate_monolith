<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class BookingNotOpenException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('Booking is not open for this activity.');
    }

    protected function getInternalCode(): int
    {
        return 4006;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_CONFLICT;
    }

    protected function getTitle(): string
    {
        return 'Booking not open';
    }
}
