<?php

namespace Deviate\Users\Transformers;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Users\Models\Eloquent\Avatar;

class AvatarTransformer
{
    use ConvertsHashIds;

    public function transform(?Avatar $avatar): array
    {
        return !$avatar ? [] : [
            'user_id'    => $this->encode($avatar->user_id),
            'path'       => $avatar->path,
            'created_at' => $avatar->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $avatar->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => optional($avatar->deleted_at)->format('Y-m-d H:i:s'),
        ];
    }
}
