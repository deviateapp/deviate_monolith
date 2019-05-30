<?php

namespace Deviate\Usergroups\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Usergroups\Exceptions\UpdateUsergroupValidationException;
use Deviate\Usergroups\Rules\UniqueName;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdateUsergroupValidator extends AbstractValidator
{
    private $uniqueName;

    public function __construct(UniqueName $uniqueName)
    {
        $this->uniqueName = $uniqueName;
    }

    protected function rules(): array
    {
        return [
            'name'          => [
                'sometimes',
                'string',
                'min:3',
                'max:30',
                $this->uniqueName
                    ->forOrganisation($this->data['organisation_id'])
                    ->ignore($this->data['id']),
            ],
            'description'   => ['sometimes', 'string', 'min:10', 'max:500'],
            'is_supergroup' => ['sometimes', 'bool'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdateUsergroupValidationException($validator->getMessageBag());
    }
}
