<?php

namespace Deviate\Activities\Rules;

use Carbon\Carbon;
use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Exception;
use Illuminate\Contracts\Validation\Rule;

abstract class ActivityDates implements Rule
{
    /** @var ActivityCollectionsRepositoryInterface */
    private $repository;

    /** @var string */
    private $forCollection;

    public function __construct(ActivityCollectionsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function forCollection(string $collectionId): ActivityDates
    {
        $this->forCollection = $collectionId;

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
            $collection = $this->repository->fetchById($this->forCollection);

            return Carbon::parse($value)->between(
                Carbon::parse($collection['activities_start_at']),
                Carbon::parse($collection['activities_end_at'])
            );
        } catch (Exception $exception) {
            return false;
        }
    }
}
