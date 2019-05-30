<?php

namespace Deviate\Users\Validators;

use Deviate\Shared\Rules\OrganisationExists;
use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Users\Exceptions\NewUserValidationException;
use Deviate\Users\Rules\UniqueEmail;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class NewUserValidator extends AbstractValidator
{
    private $organisationExists;
    private $uniqueEmail;

    public function __construct(OrganisationExists $organisationExists, UniqueEmail $uniqueEmail)
    {
        $this->organisationExists = $organisationExists;
        $this->uniqueEmail        = $uniqueEmail;
    }

    protected function rules(): array
    {
        return [
            'organisation_id' => ['required', 'numeric', $this->organisationExists],
            'forename'        => ['required', 'string', 'min:2', 'max:20'],
            'surname'         => ['required', 'string', 'min:2', 'max:20'],
            'email'           => ['required', 'email', $this->uniqueEmail->uniqueTo($this->data['organisation_id'])],
            'password'        => ['required', 'string', 'min:6'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewUserValidationException($validator->getMessageBag());
    }
}
