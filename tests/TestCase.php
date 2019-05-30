<?php

namespace Tests;

use Deviate\Shared\Responses\AbstractApiResponse;
use Deviate\Shared\Traits\ConvertsHashIds;
use Deviate\Users\Contracts\Factories\Avatars\GeneratorAdapterInterface;
use Deviate\Users\Factories\Avatars\BlankAdapter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use TestSeeder;
use Illuminate\Foundation\Testing\Assert as PHPUnit;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('avatars');

        $this->overrideBindings();

        $this->seed(TestSeeder::class);

        $this->addTestHelpersToApiErrorResponse();
    }

    private function overrideBindings()
    {
        $this->app->bind(GeneratorAdapterInterface::class, BlankAdapter::class);
    }

    private function addTestHelpersToApiErrorResponse()
    {
        AbstractApiResponse::macro('assertException', function (array $expectation) {
            $meta = Arr::get($expectation, 'meta', []);
            $actual = Arr::only($this->toArray(), array_keys(Arr::except($expectation, 'meta')));

            PHPUnit::assertEquals(Arr::except($expectation, 'meta'), $actual);

            foreach ($meta as $key) {
                PHPUnit::assertArrayHasKey($key, Arr::get($this->toArray(), 'meta', []));
            }
        });

        AbstractApiResponse::macro('assertContains', function (array $expectations) {
            $actual = $this->only(array_keys($expectations));

            PHPUnit::assertEquals($expectations, $actual);
        });

        AbstractApiResponse::macro('assertSuccessful', function () {
            PHPUnit::assertTrue($this->isSuccessful());
        });

        AbstractApiResponse::macro('assertNotSuccessful', function () {
            PHPUnit::assertFalse($this->isSuccessful());
        });

        AbstractApiResponse::macro('assertIsPaginated', function (array $expected) {
            PHPUnit::assertArrayHasKey('meta', $this->toArray());
            PHPUnit::assertArrayHasKey('data', $this->toArray());

            $meta = $this->get('meta', []);
            PHPUnit::assertEquals($expected, Arr::only($meta, array_keys($expected)));
        });

        AbstractApiResponse::macro('assertPaginatedResultsContains', function (array $expectedResults) {
            foreach ($expectedResults as $index => $expectedResult) {
                $actual = $this->get('data.' . $index, []);

                $actual = Arr::only($actual, array_keys($expectedResult));

                PHPUnit::assertEquals($expectedResult, $actual);
            }
        });

        AbstractApiResponse::macro('assertPaginatedResultsContainIdsInOrder', function (...$ids) {
            foreach ($ids as $index => $id) {
                PHPUnit::assertEquals($id, $this->get('data.' . $index . '.id'));
            }
        });
    }
}
