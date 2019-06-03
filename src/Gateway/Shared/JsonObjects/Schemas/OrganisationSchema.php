<?php

namespace Deviate\Gateway\Shared\JsonObjects\Schemas;

use Deviate\Shared\Responses\Clients\ApiResponse;

class OrganisationSchema
{
    private $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    public function getId()
    {
        return $this->response->get('id');
    }

    public function getType()
    {
        return 'organisation';
    }

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
