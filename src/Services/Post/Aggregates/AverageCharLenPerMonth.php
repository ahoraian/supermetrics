<?php declare(strict_types=1);

namespace App\Services\Post\Aggregates;

use App\Services\Common\Aggregators\AggregatorInterface;
use App\Services\Common\Collections\CollectionInterface;

class AverageCharLenPerMonth implements AggregatorInterface
{
    /**
     * @var string
     */
    public string $title = 'Average character length of posts per month';

    /**
     * @param CollectionInterface $posts
     * @return array
     */
    public function apply(CollectionInterface $posts): array
    {
        $averages = [];

        // calculate total adn counts
        array_map(function($post) use (&$totalPostLen, &$countMonth) {
            $month = $post->getCreatedTime()->format('Y-m');

            if (!isset($totalPostLen[$month])) {
                $totalPostLen[$month] = $countMonth[$month] = 0;
            }

            $totalPostLen[$month] += strlen($post->getMessage());
            $countMonth[$month]++;
        }, $posts->all());

        // calculate average of total and counts per month
        foreach ($totalPostLen as $month => $lengths) {
            $averages[$month] = round($lengths / $countMonth[$month], 2);
        }

        return $averages;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}