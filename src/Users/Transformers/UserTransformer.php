<?php

namespace Deviate\Users\Transformers;

use Deviate\Shared\Transformers\CanTransformSearchResults;
use Deviate\Shared\Transformers\TransformerInterface;
use Illuminate\Database\Eloquent\Model;

class UserTransformer implements TransformerInterface
{
    use CanTransformSearchResults;

    public function transform(Model $user): array
    {
        /** @var \Deviate\Users\Models\Eloquent\User $user */
        return [
            'id'              => $user->id,
            'organisation_id' => $user->organisation_id,
            'forename'        => $user->forename,
            'surname'         => $user->surname,
            'email'           => $user->email,
            'created_at'      => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at'      => $user->updated_at->format('Y-m-d H:i:s'),
            'disabled_at'     => optional($user->deleted_at)->format('Y-m-d H:i:s'),
        ];
    }
}
