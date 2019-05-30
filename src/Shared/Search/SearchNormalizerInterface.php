<?php

namespace Deviate\Shared\Search;

interface SearchNormalizerInterface
{
    public function normalize(SearchContainerInterface $search): SearchContainerInterface;
}
