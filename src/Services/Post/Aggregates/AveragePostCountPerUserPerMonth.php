<?php declare(strict_types=1);

namespace App\Services\Post\Aggregates;

use App\Services\Common\Aggregators\AggregatorInterface;
use App\Services\Common\Collections\CollectionInterface;

class AveragePostCountPerUserPerMonth implements AggregatorInterface
{
    /**
     * @var string
     */
    public string $title = 'Average number of posts per user per month';

    /**
     * @param CollectionInterface $posts
     * @return array
     */
    public function apply(CollectionInterface $posts): array
    {
        $result =  [];

        array_map(function ($post) use (&$userMonthlyPostCounts) {
            $month = $post->getCreatedTime()->format('Y-m');
            $user = $post->getFromId();

            // set month user if before not defined
            if (!isset($userMonthlyPostCounts[$month][$user])) {
                $userMonthlyPostCounts[$month][$user] = 0;
            }

            // calc user posts per month
            $userMonthlyPostCounts[$month][$user]++;
        }, $posts->all());

        // calc averages
        foreach ($userMonthlyPostCounts as $month => $userPosts) {
            // calc total user post number in a month
            $monthPostCount = 0;
            foreach ($userPosts as $user => $postCount) {
                $monthPostCount += $postCount;
            }

            $result[$month] = round($monthPostCount / count($userPosts), 2);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return str_replace(' ', '_', $this->title);
    }
}