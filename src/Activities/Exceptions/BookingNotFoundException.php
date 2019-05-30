<?php

namespace Deviate\Activities\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Symfony\Component\HttpFoundation\Response;

class BookingNotFoundException extends AbstractApiException
{
    public function __construct()
    {
        parent::__construct('The booking could not be found.');
    }

    protected function getInternalCode(): int
    {
        return 4011;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    protected function getTitle(): string
    {
        return 'Booking not found';
    }
}
