<?php

namespace Deviate\Usergroups\Validators;

use Deviate\Shared\Validation\AbstractValidator;
use Deviate\Usergroups\Exceptions\NewUsergroupValidationException;
use Deviate\Shared\Rules\OrganisationExists;
use Deviate\Usergroups\Rules\UniqueName;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class NewUsergroupValidator extends AbstractValidator
{
    private $organisationExists;
    private $uniqueName;

    public function __construct(OrganisationExists $organisationExists, UniqueName $uniqueName)
    {
        $this->organisationExists = $organisationExists;
        $this->uniqueName         = $uniqueName;
    }

    protected function rules(): array
    {
        return [
            'organisation_id' => ['required', 'numeric', $this->organisationExists],
            'name'            => [
                'required',
                'string',
                'min:3',
                'max:30',
                $this->uniqueName->forOrganisation($this->data['organisation_id'] ?? null),
            ],
            'description'     => ['required', 'string', 'min:10', 'max:500'],
            'is_supergroup'   => ['required', 'bool'],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewUsergroupValidationException($validator->getMessageBag());
    }
}
