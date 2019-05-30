<?php

namespace Deviate\Usergroups\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Usergroups\Exceptions\UpdateUsergroupValidationException;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class ApplyPermissionsValidator extends AbstractValidator
{
    protected function formatData(array $data): array
    {
        return $data;
    }

    protected function rules(): array
    {
        return [
            'permissions.*.key'               => ['required', 'string'],
            'permissions.*.must_own_resource' => ['sometimes', 'bool'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdateUsergroupValidationException($validator->getMessageBag());
    }
}
