<?php

namespace Deviate\Activities\Rules;

use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Exceptions\ActivityCollectionNotFoundException;
use Illuminate\Contracts\Validation\Rule;

class ActivityCollectionExists implements Rule
{
    /** @var ActivityCollectionsRepositoryInterface */
    private $repository;

    public function __construct(ActivityCollectionsRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
            $this->repository->fetchById($value);

            return true;
        } catch (ActivityCollectionNotFoundException $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The activity collection does not exist';
    }
}
