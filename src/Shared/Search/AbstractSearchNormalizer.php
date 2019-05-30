<?php

namespace Deviate\Shared\Search;

abstract class AbstractSearchNormalizer implements SearchNormalizerInterface
{
    public function normalize(SearchContainerInterface $search): SearchContainerInterface
    {
        return tap(new SearchContainer, function (SearchContainerInterface $container) use ($search) {
            $this->mapSearch($container, $search);
        });
    }

    protected function mapSearch(SearchContainerInterface $container, SearchContainerInterface $search): void
    {
        $container->perPage($search->getLimitPerPage());
        $container->forPage($search->getPage());

        foreach ($this->transform($search->getFilters()) as $filter) {
            $container->addFilter($filter);
        }

        foreach ($this->transform($search->getSorts()) as $sort) {
            $container->addSort($sort);
        }
    }

    protected function transform(array $entries): array
    {
        $allowed = [];

        /** @var QueryApplicatorInterface $entry */
        foreach ($entries as $entry) {
            if ($entry->isWhitelisted($this->whitelist())) {
                $allowed[] = $entry->transformField($this->map());
            }
        }

        return $allowed;
    }

    abstract protected function whitelist(): array;
    abstract protected function map(): array;
}
