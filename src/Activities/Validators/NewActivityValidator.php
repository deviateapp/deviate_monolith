<?php

namespace Deviate\Activities\Validators;

use Deviate\Activities\Rules\ActivityCollectionExists;
use Deviate\Activities\Rules\ActivityEndDate;
use Deviate\Activities\Rules\ActivityStartDate;
use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Activities\Exceptions\NewActivityValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class NewActivityValidator extends AbstractValidator
{
    private $starts;
    private $ends;
    private $collectionExists;

    private $rules = [
        'activity_collection_id' => ['required', 'numeric'],
        'name'                   => ['required', 'string', 'min:3', 'max:50'],
        'description'            => ['required', 'string', 'min:50'],
        'starts_at'              => [
            'required',
            'date_format:Y-m-d',
            'before_or_equal:ends_at',
        ],
        'ends_at'                => [
            'required',
            'date_format:Y-m-d',
            'after_or_equal:starts_at',
        ],
        'places'                 => ['required', 'numeric', 'min:0', 'max:999'],
        'cost'                   => ['required', 'numeric', 'min:0'],
        'is_hidden'              => ['sometimes', 'boolean'],
        'is_invite_only'         => ['sometimes', 'boolean'],
    ];

    public function __construct(
        ActivityStartDate $starts,
        ActivityEndDate $ends,
        ActivityCollectionExists $collectionExists
    ) {
        $this->starts           = $starts;
        $this->ends             = $ends;
        $this->collectionExists = $collectionExists;
    }

    protected function rules(): array
    {
        $this->rules['activity_collection_id'][] = $this->collectionExists;
        $this->rules['starts_at'][]              = $this->starts->forCollection($this->data['activity_collection_id']);
        $this->rules['ends_at'][]                = $this->ends->forCollection($this->data['activity_collection_id']);

        return $this->rules;
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewActivityValidationException($validator->getMessageBag());
    }
}
