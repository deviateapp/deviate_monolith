<?php

namespace App\Console\Commands\Development\Helpers;

class TransformsStubs
{
    /** @var string */
    private $stub;

    /** @var array */
    private $code;

    public function __construct(string $stub, array $code = [])
    {
        $this->stub = $stub;
        $this->code = $code;
    }

    public function remove(string $type, bool $remove): void
    {
        if (!$remove) {
            return;
        }

        foreach ($this->code[$type] as $code) {
            $this->stub = str_replace($code, '', $this->stub);
        }
    }

    public function replace(string $template, string $replacement): void
    {
        $this->stub = str_replace($template, $replacement, $this->stub);
    }

    public function getStub(): string
    {
        return $this->stub;
    }
}
