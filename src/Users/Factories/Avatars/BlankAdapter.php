<?php

namespace Deviate\Users\Factories\Avatars;

use Deviate\Shared\Traits\ConvertsFileContent;
use Deviate\Users\Contracts\Factories\Avatars\GeneratorAdapterInterface;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class BlankAdapter implements GeneratorAdapterInterface
{
    use ConvertsFileContent;

    public function getAvatar(): File
    {
        $file = UploadedFile::fake()->image('blank.jpg', 80, 80);

        $content = $file->openFile()->fread($file->getSize());

        return $this->fileFromContent(base64_decode($content))->toFile();
    }
}
