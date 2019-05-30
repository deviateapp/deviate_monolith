<?php

namespace Deviate\Organisations\Validators;

use Deviate\Organisations\Rules\UniqueSlug;
use Deviate\Organisations\Exceptions\NewOrganisationValidationException;
use Deviate\Shared\Validation\AbstractValidator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class NewOrganisationValidator extends AbstractValidator
{
    private $slug;

    public function __construct(UniqueSlug $slug)
    {
        $this->slug = $slug;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'slug' => ['nullable', 'string', 'min:3', 'max:40', $this->slug],
        ];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new NewOrganisationValidationException($validator->errors());
    }
}
