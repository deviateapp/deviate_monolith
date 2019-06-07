<?php

namespace Tests\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\LinkCollection;
use Tests\TestCase;

class LinkCollectionTest extends TestCase
{
    /** @test */
    public function a_link_can_be_added_to_a_collection()
    {
        $links = new LinkCollection;

        $links->add('self', 'https://deviate.test/api/foo/bar');

        $this->assertEquals([
            'self' => 'https://deviate.test/api/foo/bar',
        ], $links->toArray());
    }

    /** @test */
    public function an_array_of_links_can_be_added()
    {
        $links = new LinkCollection;

        $links->add([
            'self' => 'https://deviate.test/api/foo/bar',
            'parent' => 'https://deviate.test/api/foo',
        ]);

        $this->assertEquals([
            'self' => 'https://deviate.test/api/foo/bar',
            'parent' => 'https://deviate.test/api/foo',
        ], $links->toArray());
    }
}
