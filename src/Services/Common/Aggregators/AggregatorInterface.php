<?php declare(strict_types=1);

namespace App\Services\Common\Aggregators;

use App\Services\Common\Collections\CollectionInterface;

interface AggregatorInterface
{
    /**
     * Calculate result by aggregator and set results
     * @param CollectionInterface $data
     * @return array
     */
    public function apply(CollectionInterface $data) : array;

    /**
     * Return aggregator title
     * @return string
     */
    public function getTitle(): string;
}
