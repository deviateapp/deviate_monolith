<?php

namespace Tests\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\Document;
use Deviate\Gateway\Shared\JsonObjects\Resource;
use Deviate\Gateway\Shared\JsonObjects\ResourceCollection;
use Deviate\Gateway\Shared\JsonObjects\Schemas\OrganisationSchema;
use Deviate\Shared\Responses\Clients\ApiResponse;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_empty_document()
    {
        $document = new Document;

        $this->assertEquals([
            'links'    => [],
            'data'     => [],
            'includes' => [],
            'meta'     => [],
        ], $document->toArray());
    }

    /** @test */
    public function a_primary_resource_can_be_added()
    {
        $resource = new Resource(new OrganisationSchema(new ApiResponse([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ])));

        $document = new Document($resource);

        $this->assertEquals([
            'links'    => [],
            'data'     => [
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
            ],
            'includes' => [],
            'meta'     => [],
        ], $document->toArray());
    }

    /** @test */
    public function a_collection_of_resources_can_be_added_to_a_document()
    {
        $resourceA = new Resource(new OrganisationSchema(new ApiResponse([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ])));

        $resourceB = clone $resourceA;

        $document = new Document(new ResourceCollection([$resourceA, $resourceB]));

        $this->assertEquals([
            'links'    => [],
            'data'     => [
                [
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
                ],
                [
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
                ],
            ],
            'includes' => [],
            'meta'     => [],
        ], $document->toArray());
    }

    /** @test */
    public function additional_resources_can_be_added_to_the_document()
    {
        $document = new Document;

        $document->addInclude(new Resource(new OrganisationSchema(new ApiResponse([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]))));

        $this->assertCount(1, $document->getIncludes());

        $this->assertEquals([
            'links'    => [],
            'data'     => [],
            'includes' => [
                [
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
                ],
            ],
            'meta'     => [],
        ], $document->toArray());
    }

    /** @test */
    public function a_collection_of_additional_includes_Can_be_added_to_a_document()
    {
        $document = new Document;
        $resource = new Resource(new OrganisationSchema(new ApiResponse([
            'id'         => 1,
            'name'       => 'Deviate',
            'slug'       => 'deviate',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ])));

        $document->addInclude(new ResourceCollection([$resource, $resource]));

        $this->assertCount(2, $document->getIncludes());

        $this->assertEquals([
            'links'    => [],
            'data'     => [],
            'includes' => [
                [
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
                ],
                [
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
                ],
            ],
            'meta'     => [],
        ], $document->toArray());
    }

    /** @test */
    public function meta_information_can_be_added_to_a_document()
    {
        $document = new Document;

        $document->addMeta([
            'foo' => [
                'bar',
                'baz',
            ],
        ]);

        $document->addMeta('baz', 'bar');

        $this->assertEquals([
            'foo' => [
                'bar',
                'baz',
            ],
            'baz' => 'bar',
        ], $document->toArray()['meta']);
    }

    /** @test */
    public function test_links_can_be_added_to_a_document()
    {
        $document = new Document;

        $document->addLink([
            'self' => 'https://deviate.test/api/organisations/1',
            'related' => 'https://deviate.test/api/organisations',
        ]);

        $document->addLink('root', 'https://deviate.test/api');

        $this->assertEquals([
            'self' => 'https://deviate.test/api/organisations/1',
            'related' => 'https://deviate.test/api/organisations',
            'root' => 'https://deviate.test/api',
        ], $document->toArray()['links']);
    }
}
