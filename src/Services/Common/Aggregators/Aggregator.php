<?php declare(strict_types=1);

namespace App\Services\Common\Aggregators;

use App\Services\Common\Collections\CollectionInterface;

class Aggregator
{
    /**
     * @var array
     */
    private array $aggregators = [];

    /**
     * @param AggregatorInterface $aggregator
     * @return void
     */
    public function add(AggregatorInterface $aggregator) : void
    {
        array_push($this->aggregators, $aggregator);
    }

    /**
     * @return array
     */
    public function getAggregators(): array
    {
        return $this->aggregators;
    }

    /**
     * @param array $aggregators
     */
    public function setAggregators(array $aggregators): void
    {
        $this->aggregators = $aggregators;
    }

    /**
     * Handle aggregators and return statistics
     * @param CollectionInterface $collection
     * @return array
     */
    public function handle(CollectionInterface $collection) : array
    {
        $result = [];

        foreach ($this->aggregators as $aggregator) {
            $key = str_replace(' ', '_', strtolower($aggregator->getTitle()));
            $result[$key] = $aggregator->apply($collection);
        }

        return $result;
    }
}