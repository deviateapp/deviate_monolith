<?php

namespace Deviate\Users\Rules;

use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Validation\Rule;

class UniqueEmail implements Rule
{
    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var string */
    private $organisationId;

    /** @var string */
    private $excludingUserId;

    public function __construct(FetchUsersRepositoryInterface $fetchesUsers)
    {
        $this->fetchesUsers = $fetchesUsers;
    }

    public function uniqueTo(?string $organisationId): UniqueEmail
    {
        $this->organisationId = $organisationId;

        return $this;
    }

    public function excluding(string $id): UniqueEmail
    {
        $this->excludingUserId = $id;

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
        try {
            $user = $this->fetchesUsers->fetchUserByCredentials([
                'organisation_id' => $this->organisationId,
                'email'           => $value,
            ]);
        } catch (UserNotFoundException $exception) {
            return true;
        }

        return $user['id'] === $this->excludingUserId;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email :value has already been registered in this organisation';
    }
}
