<?php

namespace Deviate\Users\Contracts\Factories\Avatars;

use Illuminate\Http\File;

interface GeneratorAdapterInterface
{
    public function getAvatar(): File;
}
