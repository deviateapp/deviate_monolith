<?php

namespace Deviate\Users\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Users\Exceptions\UpdatePasswordValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdatePasswordValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdatePasswordValidationException($validator->getMessageBag());
    }
}
