<?php

namespace Deviate\Activities\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Activities\Exceptions\NewActivityCollectionValidationException;
use Deviate\Shared\Rules\OrganisationExists;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class NewActivityCollectionValidator extends AbstractValidator
{
    private $organisationExists;
    private $validationRules = [
        'organisation_id'     => ['required', 'string', 'size:6'],
        'name'                => ['required', 'string', 'min:3', 'max:50'],
        'description'         => ['required', 'string', 'min:10', 'max:500'],
        'booking_starts_at'   => ['required', 'date_format:Y-m-d H:i:s', 'before:booking_ends_at'],
        'booking_ends_at'     => [
            'required',
            'date_format:Y-m-d H:i:s',
            'after:booking_starts_at',
            'before_or_equal:payment_ends_at',
        ],
        'payment_starts_at'   => [
            'required',
            'date_format:Y-m-d H:i:s',
            'after_or_equal:booking_starts_at',
            'before:payment_ends_at',
        ],
        'payment_ends_at'     => [
            'required',
            'date_format:Y-m-d H:i:s',
            'after:payment_starts_at',
            'before:activities_start_at',
        ],
        'activities_start_at' => [
            'required',
            'date_format:Y-m-d H:i:s',
            'after:payment_ends_at',
            'before:activities_end_at',
        ],
        'activities_end_at'   => ['required', 'date_format:Y-m-d H:i:s', 'after:activities_start_at'],
    ];

    public function __construct(OrganisationExists $organisationExists)
    {
        $this->organisationExists = $organisationExists;
    }

    protected function rules(): array
    {
        $this->validationRules['organisation_id'][] = $this->organisationExists;

        return $this->validationRules;
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewActivityCollectionValidationException($validator->getMessageBag());
    }
}
