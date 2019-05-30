<?php

namespace Deviate\Usergroups\Tests\Services\Usergroups;

use Deviate\Shared\Search\Filters\MatchesFuzzy;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\Sorting\RegularSort;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Usergroups\Tests\Services\TestCase;

class SearchUsergroupsTest extends TestCase
{
    /** @test */
    public function it_can_list_usergroups()
    {
        $container = new SearchContainer;
        $container->perPage(10);

        $response = $this->searchClient->search($container);

        $response->assertSuccessful();
        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 10,
            'total_pages'   => 1,
            'total_records' => 4,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1, 3, 2, 4);
    }

    /** @test */
    public function it_can_limit_the_number_of_results_to_a_page()
    {
        $container = new SearchContainer;
        $container->perPage(2);

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'per_page'      => 2,
            'total_pages'   => 2,
            'total_records' => 4,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1, 3);
    }

    /** @test */
    public function it_can_specify_the_page()
    {
        $container = new SearchContainer;
        $container->perPage(2)->forPage(2);

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'current_page' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2, 4);
    }

    /** @test */
    public function it_can_specify_a_single_order()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::descending('organisation'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(3, 4, 1, 2);
    }

    /** @test */
    public function it_removes_sort_fields_that_arent_whitelisted()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::ascending('id'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(1, 3);
    }

    /** @test */
    public function it_can_map_fields_correctly()
    {
        Usergroup::get()->each(function (Usergroup $usergroup, $index) {
            $usergroup->update(['created_at' => $usergroup->created_at->addSecond($index)]);
        });

        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::descending('created'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(4, 3);
    }

    /** @test */
    public function it_can_apply_filters()
    {
        $container = new SearchContainer;
        $container->addFilter(new MatchesFuzzy('name', 'Network'));

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'total_records' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(1, 3);
    }
}
