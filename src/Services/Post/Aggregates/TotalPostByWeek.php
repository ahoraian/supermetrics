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
     * @param CollectionInterface $posts
     * @return array
     */
    public function apply(CollectionInterface $posts): array
    {
        // get weekly post counts (week number of year)
        array_map(function($post) use (&$weeklyPostCount) {
            $weekInYear = $post->getCreatedTime()->format('Y-W');

            if (!isset($weeklyPostCount[$weekInYear])) {
                $weeklyPostCount[$weekInYear] = 0;
            }

            $weeklyPostCount[$weekInYear]++;
        }, $posts->all());

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