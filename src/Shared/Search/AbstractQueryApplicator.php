<?php

namespace Deviate\Shared\Search;

use function array_key_exists;

abstract class AbstractQueryApplicator implements QueryApplicatorInterface
{
    /** @var string */
    protected $field;

    public function transformField(array $map): QueryApplicatorInterface
    {
        $this->field = array_key_exists($this->field, $map) ? $map[$this->field] : $this->field;

        return $this;
    }

    public function isWhitelisted(array $whitelist): bool
    {
        return in_array($this->field, $whitelist);
    }
}
