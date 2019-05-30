<?php

namespace Deviate\Users\Factories\Avatars;

use Deviate\Users\Contracts\Factories\Avatars\GeneratorAdapterInterface;
use Illuminate\Http\File;

class AvatarFactory
{
    /** @var GeneratorAdapterInterface */
    private $adapter;

    public function __construct(GeneratorAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function make(): File
    {
        return $this->adapter->getAvatar();
    }
}
