<?php

namespace Deviate\Users\Tests\Services\Users;

use Deviate\Shared\Search\Filters\MatchesFuzzy;
use Deviate\Shared\Search\SearchContainer;
use Deviate\Shared\Search\Sorting\RegularSort;
use Deviate\Users\Tests\Services\TestCase;

class SearchUsersTest extends TestCase
{
    /** @test */
    public function it_can_list_users()
    {
        $container = new SearchContainer;
        $container->perPage(5);

        $response = $this->searchClient->search($container);

        $response->assertSuccessful();
        $response->assertIsPaginated([
            'current_page'  => 1,
            'per_page'      => 5,
            'total_pages'   => 2,
            'total_records' => 7,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(7),
            $this->encode(5),
            $this->encode(4),
            $this->encode(6),
            $this->encode(1)
        );
    }

    /** @test */
    public function it_can_limit_the_number_of_results_to_a_page()
    {
        $container = new SearchContainer;
        $container->perPage(2);

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'per_page'      => 2,
            'total_pages'   => 4,
            'total_records' => 7,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(7), $this->encode(5));
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

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(5));
    }

    /** @test */
    public function it_can_specify_a_single_order()
    {
        $container = new SearchContainer;
        $container->addSort(RegularSort::ascending('email'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(7), // Alfie
            $this->encode(1), // Brody
            $this->encode(5), // Jayne
            $this->encode(3), // Lisa
            $this->encode(4), // Neil
            $this->encode(6), // Neve
            $this->encode(2)  // Phil
        );
    }

    /** @test */
    public function it_removes_sort_fields_that_arent_whitelisted()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::ascending('invalid'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(7), $this->encode(5));
    }

    /** @test */
    public function it_can_map_fields_correctly()
    {
        $container = new SearchContainer;
        $container->perPage(2)->addSort(RegularSort::descending('created'));

        $response = $this->searchClient->search($container);

        $response->assertPaginatedResultsContainIdsInOrder($this->encode(7), $this->encode(5));
    }

    /** @test */
    public function it_can_apply_filters()
    {
        $container = new SearchContainer;
        $container->addFilter(new MatchesFuzzy('email', 'deviate'));

        $response = $this->searchClient->search($container);

        $response->assertIsPaginated([
            'total_records' => 3,
        ]);

        $response->assertPaginatedResultsContainIdsInOrder(
            $this->encode(1),
            $this->encode(3),
            $this->encode(2)
        );
    }
}
