<?php

namespace Deviate\Gateway\Shared\JsonObjects\Schemas;

use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipCollection;
use Deviate\Gateway\Shared\JsonObjects\Relationships\SingularRelationship;

class UserSchema extends AbstractSchema
{
    protected $type = 'user';

    public function defaultRelationships(): RelationshipCollection
    {
        return new RelationshipCollection([
            new SingularRelationship('organisation', $this->response->get('organisation_id')),
        ]);
    }

    public function toArray()
    {
        return [
            'name'    => [
                'forename'  => $this->response->get('forename'),
                'surname'   => $this->response->get('surname'),
                'full_name' => sprintf(
                    '%s %s', $this->response->get('forename'), $this->response->get('surname')
                ),
            ],
            'contact' => [
                'email' => $this->response->get('email'),
            ],
            'status'  => $this->response->get('disabled_at') ? 'disabled' : 'active',
            'dates'   => [
                'created_at'  => $this->response->get('created_at'),
                'updated_at'  => $this->response->get('updated_at'),
                'disabled_at' => $this->response->get('disabled_at'),
            ],
        ];
    }
}
