<?php

namespace Deviate\Shared\Exceptions;

use Exception;
use Ramsey\Uuid\Uuid;

abstract class AbstractApiException extends Exception
{
    /** @var string */
    protected $id;

    /** @var array|null */
    protected $errors;

    public function __construct()
    {
        parent::__construct(...func_get_args());

        $this->id = Uuid::uuid4()->toString();
    }

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'code'        => $this->getInternalCode(),
            'status'      => $this->getHttpStatus(),
            'title'       => $this->getTitle(),
            'description' => $this->getMessage(),
            'meta'        => $this->getMeta(),
        ];
    }

    protected function getMeta(): ?array
    {
        return $this->errors;
    }

    abstract protected function getInternalCode(): int;
    abstract protected function getHttpStatus(): int;
    abstract protected function getTitle(): string;
}
