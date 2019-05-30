<?php

namespace Deviate\Shared\Traits;

use Deviate\Shared\Factories\FileFactory;
use Illuminate\Http\File;

trait ConvertsFileContent
{
    public function fileFromContent(string $content): FileFactory
    {
        return FileFactory::fromContent($content);
    }

    public function fromFile(File $file): FileFactory
    {
        return FileFactory::fromFile($file);
    }
}
