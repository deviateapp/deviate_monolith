<?php

namespace Deviate\Users\Factories\Avatars;

use Deviate\Shared\Traits\ConvertsFileContent;
use Deviate\Users\Contracts\Factories\Avatars\GeneratorAdapterInterface;
use Illuminate\Http\File;
use Ramsey\Uuid\Uuid;

class GravatarAdapter implements GeneratorAdapterInterface
{
    use ConvertsFileContent;

    public function getAvatar(): File
    {
        $url = sprintf('https://www.gravatar.com/avatar/%s?s=80&d=identicon&r=g', Uuid::uuid4()->toString());

        $content = base64_encode(file_get_contents($url));

        return $this->fileFromContent($content)->toFile();
    }
}
