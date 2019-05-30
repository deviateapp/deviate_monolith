<?php

namespace Deviate\Users\Exceptions;

use Deviate\Shared\Exceptions\AbstractApiException;
use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class UploadAvatarValidationException extends AbstractApiException
{
    public function __construct(MessageBag $errors)
    {
        parent::__construct('There was an error while trying to upload the new avatar');

        $this->errors = $errors->toArray();
    }

    protected function getInternalCode(): int
    {
        return 2006;
    }

    protected function getHttpStatus(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    protected function getTitle(): string
    {
        return 'Validation error';
    }
}
