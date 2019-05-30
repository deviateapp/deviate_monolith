<?php

namespace Deviate\Shared\Factories;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class FileFactory
{
    /** @var File */
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public static function fromContent(string $content): FileFactory
    {
        $path   = tempnam(sys_get_temp_dir(), 'tmp_');
        $handle = fopen($path, "w");

        fwrite($handle, base64_decode($content));
        fclose($handle);

        return new static(new File($path));
    }

    public static function fromFile(File $file): FileFactory
    {
        return new static($file);
    }

    public function toContent(): string
    {
        return $this->file->openFile()->fread($this->file->getSize());
    }

    public function toFile(): File
    {
        return $this->file;
    }

    public function toUploadedFile(): UploadedFile
    {
        return new UploadedFile(
            $this->file->path(),
            $this->file->getFilename(),
            $this->file->getMimeType(),
            null,
            config('app.env') === 'testing'
        );
    }
}
