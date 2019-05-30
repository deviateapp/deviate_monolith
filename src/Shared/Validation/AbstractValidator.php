<?php

namespace Deviate\Shared\Validation;

use function array_merge;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class AbstractValidator
{
    /** @var array */
    protected $data;

    /** @var array */
    private $context = [];

    public function validate(array ...$data): array
    {
        $this->data = $this->formatData(array_merge(...$data));

        $validator = Validator::make($this->data, $this->rules(), $this->messages());

        if ($validator->fails()) {
            $this->fail($validator);
        }

        return $this->data;
    }

    public function withContext(array $data): AbstractValidator
    {
        $this->context = $data;

        return $this;
    }

    public function context(string $key, $default = null)
    {
        return Arr::get($this->context, $key, $default);
    }

    protected function formatData(array $data): array
    {
        return $data;
    }

    protected function rules(): array
    {
        return [];
    }

    protected function messages(): array
    {
        return [];
    }

    protected function fail(ValidatorContract $validator): void
    {
        throw new ValidationException($validator);
    }
}
