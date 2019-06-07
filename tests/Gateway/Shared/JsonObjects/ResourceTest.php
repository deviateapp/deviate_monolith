<?php

namespace Tests\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\Relationships\MultipleRelationships;
use Deviate\Gateway\Shared\JsonObjects\Relationships\SingularRelationship;
use Deviate\Gateway\Shared\JsonObjects\Resource;
use Deviate\Gateway\Shared\JsonObjects\Schemas\OrganisationSchema;
use Deviate\Shared\Responses\Clients\ApiResponse;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    /** @var Resource */
    private $resource;

    /** @test */
    public function a_resource_can_be_converted_to_an_array()
    {
        $this->assertEquals([
            'type'          => 'organisation',
            'id'            => 1,
            'attributes'    => [
                'name'  => [
                    'title' => 'Deviate',
                    'slug'  => 'deviate',
                ],
                'dates' => [
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ],
            'links'         => [],
            'relationships' => [],
            'meta'          => [],
        ], $this->resource->toArray());
    }

    /** @test */
    public function links_can_be_added_to_a_resource()
    {
        $this->resource->addLink('self', 'https://deviate.test/api/foo/bar');

        $this->assertEquals([
            'type'          => 'organisation',
            'id'            => 1,
            'attributes'    => [
                'name'  => [
                    'title' => 'Deviate',
                    'slug'  => 'deviate',
                ],
                'dates' => [
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ],
            'links'         => [
                'self' => 'https://deviate.test/api/foo/bar',
            ],
            'relationships' => [],
            'meta'          => [],
        ], $this->resource->toArray());
    }

    /** @test */
    public function meta_data_can_be_added_to_a_resource()
    {
        $this->resource->addMeta('foo', 'bar');

        $this->assertEquals([
            'type'          => 'organisation',
            'id'            => 1,
            'attributes'    => [
                'name'  => [
                    'title' => 'Deviate',
                    'slug'  => 'deviate',
                ],
                'dates' => [
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ],
            'links'         => [],
            'relationships' => [],
            'meta'          => [
                'foo' => 'bar',
            ],
        ], $this->resource->toArray());
    }

    /** @test */
    public function a_singular_relationship_can_be_added_to_a_resource()
    {
        $relationship = new SingularRelationship('organisation', 1);

        $this->resource->addRelationship($relationship);

        $this->assertEquals([
            'type'          => 'organisation',
            'id'            => 1,
            'attributes'    => [
                'name'  => [
                    'title' => 'Deviate',
                    'slug'  => 'deviate',
                ],
                'dates' => [
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ],
            'links'         => [],
            'relationships' => [
                'organisation' => [
                    'data' => [
                        'type' => 'organisation',
                        'id' => 1,
                    ],
                    'links' => []
                ],
            ],
            'meta'          => [],
        ], $this->resource->toArray());
    }

    /** @test */
    public function a_multiple_relationship_can_be_added_to_a_resource()
    {
        $relationships = new MultipleRelationships('organisation', [1, 2, 3]);

        $this->resource->addRelationship($relationships);

        $this->assertEquals([
            'type'          => 'organisation',
            'id'            => 1,
            'attributes'    => [
                'name'  => [
                    'title' => 'Deviate',
                    'slug'  => 'deviate',
                ],
                'dates' => [
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ],
            'links'         => [],
            'relationships' => [
                'organisation' => [
                    'data' => [
                        [
                            'type' => 'organisation',
                            'id' => 1,
                        ],
                        [
                            'type' => 'organisation',
                            'id' => 2,
                        ],
                        [
                            'type' => 'organisation',
                            'id' => 3,
                        ],
                    ],
                    'links' => []
                ],
            ],
            'meta'          => [],
        ], $this->resource->toArray());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $schema = new OrganisationSchema(new ApiResponse([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]));

        $this->resource = new Resource($schema);
    }
}
