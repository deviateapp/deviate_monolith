<?php

namespace Deviate\Users\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Users\Exceptions\UpdateCoreDetailsValidationException;
use Deviate\Users\Rules\UniqueEmail;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdateCoreDetailsValidator extends AbstractValidator
{
    private $uniqueEmail;

    public function __construct(UniqueEmail $uniqueEmail)
    {
        $this->uniqueEmail = $uniqueEmail;
    }

    protected function rules(): array
    {
        return [
            'forename' => ['sometimes', 'string', 'min:2', 'max:20'],
            'surname'  => ['sometimes', 'string', 'min:2', 'max:20'],
            'email'    => ['sometimes', 'email', $this->uniqueEmailValidationRule()],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdateCoreDetailsValidationException($validator->getMessageBag());
    }

    private function uniqueEmailValidationRule()
    {
        return $this->uniqueEmail->uniqueTo($this->data['organisation_id'])->excluding($this->data['id']);
    }
}
