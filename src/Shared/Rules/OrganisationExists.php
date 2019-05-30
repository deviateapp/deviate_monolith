<?php

namespace Deviate\Shared\Rules;

use Deviate\Organisations\Client\ClientInterface;
use Illuminate\Contracts\Validation\Rule;

class OrganisationExists implements Rule
{
    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
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
        return $this->client->fetchOrganisationById($value)->isSuccessful();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The organisation :value does not exist.';
    }
}
