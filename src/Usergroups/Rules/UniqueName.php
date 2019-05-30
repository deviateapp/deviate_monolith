<?php

namespace Deviate\Usergroups\Rules;

use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class UniqueName implements Rule
{
    /** @var FetchUsergroupsRepositoryInterface */
    private $fetchesUsergroups;

    /** @var string */
    private $ignoreId;

    /** @var string */
    private $organisationId;

    public function __construct(FetchUsergroupsRepositoryInterface $fetchesUsergroups)
    {
        $this->fetchesUsergroups = $fetchesUsergroups;
    }

    public function ignore(?string $ignoreId = null): UniqueName
    {
        $this->ignoreId = $ignoreId;

        return $this;
    }

    public function forOrganisation(?string $organisationId): UniqueName
    {
        $this->organisationId = $organisationId;

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
        if (!$this->organisationId || !$value) {
            return false;
        }

        return !$this->fetchesUsergroups->isNameRegistered($this->organisationId, $value, $this->ignoreId);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The name for this usergroup is already in use.';
    }
}
