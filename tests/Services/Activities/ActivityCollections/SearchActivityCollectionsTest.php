<?php

namespace Deviate\Activities\Tests\Services\ActivityCollections;

use Carbon\Carbon;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Activities\Tests\Services\TestCase;
use Deviate\Shared\Search\Filters\MatchesFuzzy;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\Sorting\RegularSort;

class SearchActivityCollectionsTest extends TestCase
{
    /** @test */
    public function it_can_list_usergroups()
    {
        $container = new SearchContainer();
        $container->perPage(10);

        $response = $this->searchClient->searchCollections($container);

        $response->assertSuccessful();
        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 10,
            'total_pages'   => 1,
            'total_records' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(1),
            $this->encode(2)
        );
    }

    /** @test */
    public function it_can_limit_the_number_of_results_to_a_page()
    {
        $container = new SearchContainer;
        $container->perPage(1);

        $response = $this->searchClient->searchCollections($container);

        $response->assertIsPaginated([
            'per_page'      => 1,
            'total_pages'   => 2,
            'total_records' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(1));
    }

    /** @test */
    public function it_can_specify_the_page()
    {
        $container = new SearchContainer;
        $container->perPage(1)->forPage(2);

        $response = $this->searchClient->searchCollections($container);

        $response->assertIsPaginated([
            'current_page' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(2));
    }

    /** @test */
    public function it_can_specify_a_single_order()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::descending('name'));

        $response = $this->searchClient->searchCollections($container);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(2),
            $this->encode(1)
        );
    }

    /** @test */
    public function it_removes_sort_fields_that_arent_whitelisted()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::descending('id'));

        $response = $this->searchClient->searchCollections($container);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(1), $this->encode(2));
    }

    /** @test */
    public function it_can_map_fields_correctly()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::descending('activities_start'));

        $response = $this->searchClient->searchCollections($container);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(2), $this->encode(1));
    }

    /** @test */
    public function it_can_apply_filters()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::where('activities_start_at', 'LIKE', Carbon::now()->addYears(2)->format('Y') . '%')->first();

        $container = new SearchContainer;
        $container->addFilter(new MatchesFuzzy('name', $collection->activities_start_at->format('Y')));

        $response = $this->searchClient->searchCollections($container);

        $response->assertIsPaginated([
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(2)
        );
    }
}
