<?php

namespace Deviate\Gateway\Shared\JsonObjects\Schemas;

class OrganisationSchema extends AbstractSchema
{
    protected $type = 'organisation';

    public function toArray()
    {
        return [
            'name'  => [
                'title' => $this->response->get('name'),
                'slug'  => $this->response->get('slug'),
            ],
            'dates' => [
                'created_at' => $this->response->get('created_at'),
                'updated_at' => $this->response->get('updated_at'),
            ],
        ];
    }
}
