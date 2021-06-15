<?php declare(strict_types=1);

namespace App\Services\Post\Aggregates;

use App\Services\Common\Collections\CollectionInterface;
use App\Services\Common\Aggregators\AggregatorInterface;

class TotalPostByWeek implements AggregatorInterface
{
    /**
     * @var string
     */
    public string $title = "Total posts split by week";

    /**
     * @param CollectionInterface $data
     * @return array
     */
    public function apply(CollectionInterface $data): array
    {
        // get weekly post counts (week number of year)
        $data->map(function($post) use (&$weeklyPostCount) {
            $weekInYear = $post->getCreatedTime()->format('Y-W');

            if (!isset($weeklyPostCount[$weekInYear])) {
                $weeklyPostCount[$weekInYear] = 0;
            }

            $weeklyPostCount[$weekInYear]++;
        });

        return $weeklyPostCount;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}