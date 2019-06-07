<?php

namespace Tests\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\MetaCollection;
use Tests\TestCase;

class MetaCollectionTest extends TestCase
{
    /** @test */
    public function meta_data_can_be_added_to_a_collection()
    {
        $meta = new MetaCollection;

        $meta->add('foo', 'bar');

        $this->assertEquals([
            'foo' => 'bar',
        ], $meta->toArray());
    }

    /** @test */
    public function an_array_of_meta_data_can_be_added()
    {
        $meta = new MetaCollection;

        $meta->add([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'baz',
        ], $meta->toArray());
    }
}
