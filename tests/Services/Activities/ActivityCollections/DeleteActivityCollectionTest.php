<?php

namespace Deviate\Activities\Tests\Services\ActivityCollections;

use Deviate\Activities\Tests\Services\TestCase;

class DeleteActivityCollectionTest extends TestCase
{
    /** @test */
    public function it_can_delete_a_collection()
    {
        $response = $this->collectionsClient->deleteCollection(1);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('activity_collections', [
            'id' => 1,
        ]);
    }

    /** @test */
    public function it_returns_an_error_if_the_collection_cannot_be_found()
    {
        $response = $this->collectionsClient->deleteCollection(999);

        $response->assertException([
            'status' => 404,
        ]);
    }
}
