<?php

namespace Deviate\Activities\Validators;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Rules\ActivityEndDate;
use Deviate\Activities\Rules\ActivityStartDate;
use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Activities\Exceptions\NewActivityValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdateActivityValidator extends AbstractValidator
{
    private $startDate;
    private $endDate;
    private $activities;

    private $rules = [
        'name'           => ['sometimes', 'string', 'min:3', 'max:50'],
        'description'    => ['sometimes', 'string', 'min:50'],
        'starts_at'      => [
            'sometimes',
            'date_format:Y-m-d',
            'before_or_equal:ends_at',
        ],
        'ends_at'        => [
            'sometimes',
            'date_format:Y-m-d',
            'after_or_equal:starts_at',
        ],
        'places'         => ['sometimes', 'numeric', 'min:0', 'max:999'],
        'cost'           => ['sometimes', 'numeric', 'min:0'],
        'is_hidden'      => ['sometimes', 'boolean'],
        'is_invite_only' => ['sometimes', 'boolean'],
    ];

    public function __construct(
        ActivityStartDate $startDate,
        ActivityEndDate $endDate,
        ActivitiesRepositoryInterface $activities
    ) {
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
        $this->activities = $activities;
    }

    protected function rules(): array
    {
        $collectionId = $this->activities->fetchById($this->data['id'])['activity_collection_id'];

        $this->rules['starts_at'][] = $this->startDate->forCollection($collectionId);
        $this->rules['ends_at'][]   = $this->endDate->forCollection($collectionId);

        return $this->rules;
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewActivityValidationException($validator->getMessageBag());
    }
}
