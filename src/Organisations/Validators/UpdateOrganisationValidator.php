<?php

namespace Deviate\Organisations\Validators;

use Deviate\Organisations\Exceptions\UpdateOrganisationValidationException;
use Deviate\Organisations\Rules\UniqueSlug;
use Deviate\Shared\Validation\AbstractValidator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class UpdateOrganisationValidator extends AbstractValidator
{
    private $slug;

    public function __construct(UniqueSlug $slug)
    {
        $this->slug = $slug;
    }

    protected function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:40'],
            'slug' => ['sometimes', 'string', 'min:3', 'max:40', $this->slug->optional()->ignore($this->data['id'])],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new UpdateOrganisationValidationException($validator->errors());
    }
}
