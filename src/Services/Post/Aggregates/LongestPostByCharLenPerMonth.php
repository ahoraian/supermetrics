<?php declare(strict_types=1);

namespace App\Services\Post\Aggregates;

use App\Services\Common\Aggregators\AggregatorInterface;
use App\Services\Common\Collections\CollectionInterface;

class LongestPostByCharLenPerMonth implements AggregatorInterface
{
    /**
     * @var string
     */
    public string $title = 'Longest post by character length per month';

    /**
     * @param CollectionInterface $data
     * @return array
     */
    public function apply(CollectionInterface $data): array
    {
        $result = [];

        $data->map(function ($post) use (&$result) {
            $month = $post->getCreatedTime()->format('Y-m');
            $length = strlen($post->getMessage());

            if (!isset($longest[$month])) {
                $longest[$month] = 0;
            }

            // find largest length (compare large length with each other)
            $result[$month] = max($length, $longest[$month]);

        });

        return $result;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}