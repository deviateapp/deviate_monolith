<?php

namespace Deviate\Organisations\Tests\Services;

use Deviate\Shared\Search\Filters\MatchesFuzzy;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\Sorting\RegularSort;

class SearchOrganisationsTest extends TestCase
{
    /** @test */
    public function it_can_list_all_organisations()
    {
        $container = new SearchContainer;
        $container->perPage(5);

        $response = $this->searchClient->search($container);

        $response->assertSuccessful();
        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_pages'   => 1,
            'total_records' => 2,
        ]);

        $response->assertPaginatedResultsContains([
            [
                'id'   => 2,
                'name' => 'Citrium',
                'slug' => 'citrium',
            ],
            [
                'id'   => 1,
                'name' => 'Deviate',
                'slug' => 'deviate',
            ],
        ]);
    }

    /** @test */
    public function it_can_limit_the_number_of_results_to_a_page()
    {
        $container = new SearchContainer;
        $container->perPage(1);

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'per_page'      => 1,
            'total_pages'   => 2,
            'total_records' => 2,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2);
    }

    /** @test */
    public function it_can_specify_the_page()
    {
        $container = new SearchContainer;
        $container->perPage(1)->forPage(2);

        $response = $this->searchClient->search($container);

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

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(1, 2);
    }

    /** @test */
    public function it_removes_sort_fields_that_arent_whitelisted()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::ascending('id'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(2, 1);
    }

    /** @test */
    public function it_can_map_fields_correctly()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::descending('subdomain'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(1, 2);
    }

    /** @test */
    public function it_can_apply_filters()
    {
        $container = new SearchContainer;
        $container->addFilter(new MatchesFuzzy('subdomain', 'citrium'));

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'total_records' => 1,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(2);
    }
}
