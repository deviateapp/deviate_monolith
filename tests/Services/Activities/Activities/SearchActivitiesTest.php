<?php

namespace Deviate\Activities\Tests\Services\Activities;

use Deviate\Shared\Search\Filters\MatchesFuzzy;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\Sorting\RegularSort;
use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Tests\Services\TestCase;

class SearchActivitiesTest extends TestCase
{
    /** @test */
    public function it_can_list_activities()
    {
        $container = new SearchContainer;
        $container->perPage(10);

        $response = $this->searchClient->searchActivities($container);

        $response->assertSuccessful();
        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 10,
            'total_pages'   => 1,
            'total_records' => 3,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2, 3, 1);
    }

    /** @test */
    public function it_can_limit_the_number_of_results_to_a_page()
    {
        $container = new SearchContainer;
        $container->perPage(2);

        $response = $this->searchClient->searchActivities($container);

        $response->assertIsPaginated([
            'per_page'      => 2,
            'total_pages'   => 2,
            'total_records' => 3,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2, 3);
    }

    /** @test */
    public function it_can_specify_the_page()
    {
        $container = new SearchContainer;
        $container->perPage(2)->forPage(2);

        $response = $this->searchClient->searchActivities($container);

        $response->assertIsPaginated([
            'current_page' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1);
    }

    /** @test */
    public function it_can_specify_a_single_order()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::descending('name'));

        $response = $this->searchClient->searchActivities($container);

        $response->assertPaginatedResultsContainIdsInOrder(1, 3, 2);
    }

    /** @test */
    public function it_removes_sort_fields_that_arent_whitelisted()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::ascending('foo'));

        $response = $this->searchClient->searchActivities($container);

        $response->assertPaginatedResultsContainIdsInOrder(2, 3);
    }

    /** @test */
    public function it_can_map_fields_correctly()
    {
        Activity::get()->each(function (Activity $activity, $index) {
            $activity->update(['created_at' => $activity->created_at->addSecond($index)]);
        });

        $container = new SearchContainer;
        $container->perPage(3)->addSort(RegularSort::descending('created'));

        $response = $this->searchClient->searchActivities($container);

        $response->assertPaginatedResultsContainIdsInOrder(3, 2, 1);
    }

    /** @test */
    public function it_can_apply_filters()
    {
        $container = new SearchContainer;
        $container->addFilter(new MatchesFuzzy('name', 'Zoo'));

        $response = $this->searchClient->searchActivities($container);

        $response->assertIsPaginated([
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(3);
    }
}
