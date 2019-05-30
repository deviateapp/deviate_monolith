<?php

namespace Deviate\Organisations\Rules;

use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class UniqueSlug implements Rule
{
    /** @var FetchOrganisationsRepositoryInterface */
    private $fetchesOrganisations;

    /** @var int */
    private $ignoreId;

    /** @var bool */
    private $isOptional = false;

    public function __construct(FetchOrganisationsRepositoryInterface $fetchesOrganisations)
    {
        $this->fetchesOrganisations = $fetchesOrganisations;
    }

    public function optional(): UniqueSlug
    {
        $this->isOptional = true;

        return $this;
    }

    public function ignore(?int $ignoreId = null): UniqueSlug
    {
        $this->ignoreId = $ignoreId;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value && $this->isOptional) {
            return true;
        }

        return !$this->fetchesOrganisations->isSlugRegistered($value, $this->ignoreId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The slug provided has already been registered.';
    }
}
