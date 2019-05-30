<?php

namespace Deviate\Usergroups\Transformers;

use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Shared\Transformers\CanTransformSearchResults;
use Deviate\Shared\Transformers\TransformerInterface;
use Illuminate\Database\Eloquent\Model;

class UsergroupTransformer implements TransformerInterface
{
    use ConvertsHashIds,
        CanTransformSearchResults;

    public function transform(Model $usergroup): array
    {
        /** @var \Deviate\Usergroups\Models\Eloquent\Usergroup $usergroup */
        return [
            'id'              => $this->encode($usergroup->id),
            'organisation_id' => $this->encode($usergroup->organisation_id),
            'name'            => $usergroup->name,
            'description'     => $usergroup->description,
            'is_supergroup'   => $usergroup->is_supergroup,
            'created_at'      => $usergroup->created_at->format('Y-m-d H:i:s'),
            'updated_at'      => $usergroup->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
