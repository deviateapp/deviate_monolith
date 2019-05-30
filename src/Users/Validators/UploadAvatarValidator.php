<?php

namespace Deviate\Users\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Users\Exceptions\UploadAvatarValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UploadAvatarValidator extends AbstractValidator
{
    protected function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'dimensions:max_width=1000,max_height=1000'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UploadAvatarValidationException($validator->getMessageBag());
    }
}
