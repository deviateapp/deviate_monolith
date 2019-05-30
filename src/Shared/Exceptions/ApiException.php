<?php

namespace Deviate\Shared\Exceptions;

use Deviate\Shared\Responses\Clients\ApiErrorResponse;

class ApiException extends AbstractApiException
{
    private $original;

    public function __construct(ApiErrorResponse $original)
    {
        $this->original = $original;

        parent::__construct($this->original->get('description'));

        $this->id       = $this->original->get('id');
        $this->errors   = $this->original->get('meta');
    }

    public function getInternalCode(): int
    {
        return $this->original->get('code');
    }

    protected function getHttpStatus(): int
    {
        return $this->original->get('status');
    }

    protected function getTitle(): string
    {
        return $this->original->get('title');
    }
}
