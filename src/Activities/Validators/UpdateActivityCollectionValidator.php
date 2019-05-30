<?php

namespace Deviate\Activities\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Activities\Exceptions\UpdateActivityCollectionValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdateActivityCollectionValidator extends AbstractValidator
{
    private $validationRules = [
        'name'                => ['sometimes', 'string', 'min:3', 'max:50'],
        'description'         => ['sometimes', 'string', 'min:10', 'max:500'],
        'booking_starts_at'   => [
            'required_with:booking_ends_at,payment_starts_at,payment_ends_at,activities_start_at,activities_end_at',
            'date_format:Y-m-d H:i:s',
            'before:booking_ends_at',
        ],
        'booking_ends_at'     => [
            'required_with:booking_starts_at,payment_starts_at,payment_ends_at,activities_start_at,activities_end_at',
            'date_format:Y-m-d H:i:s',
            'after:booking_starts_at',
            'before_or_equal:payment_ends_at',
        ],
        'payment_starts_at'   => [
            'required_with:booking_starts_at,booking_ends_at,payment_ends_at,activities_start_at,activities_end_at',
            'date_format:Y-m-d H:i:s',
            'after_or_equal:booking_ends_at',
            'before:payment_ends_at',
        ],
        'payment_ends_at'     => [
            'required_with:booking_starts_at,booking_ends_at,payment_starts_at,activities_start_at,activities_end_at',
            'date_format:Y-m-d H:i:s',
            'after:payment_starts_at',
            'before:activities_start_at',
        ],
        'activities_start_at' => [
            'required_with:booking_starts_at,booking_ends_at,payment_starts_at,payment_ends_at,activities_end_at',
            'date_format:Y-m-d H:i:s',
            'after:payment_ends_at',
            'before:activities_end_at',
        ],
        'activities_end_at'   => [
            'required_with:booking_starts_at,booking_ends_at,payment_starts_at,payment_ends_at,activities_start_at',
            'date_format:Y-m-d H:i:s',
            'after:activities_start_at',
        ],
    ];

    protected function rules(): array
    {
        return $this->validationRules;
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdateActivityCollectionValidationException($validator->getMessageBag());
    }
}
