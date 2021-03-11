<?php declare(strict_types=1);

namespace App\Services\Post;

use App\Services\Common\AbstractRepository;
use App\Services\Common\Aggregators\Aggregator;
use App\Services\Common\Collections\CollectionInterface;
use App\Services\Common\Exceptions\HttpResponseException;
use App\Services\Common\HttpClients\JsonResponse;
use App\Services\Post\Aggregates\AverageCharLenPerMonth;
use App\Services\Post\Aggregates\AveragePostCountPerUserPerMonth;
use App\Services\Post\Aggregates\LongestPostByCharLenPerMonth;
use App\Services\Post\Aggregates\TotalPostByWeek;
use App\Services\Post\Collection\PostCollection;
use Throwable;

class PostRepository extends AbstractRepository
{
    /**
     * Fetch all posts
     * @return CollectionInterface
     * @throws Throwable
     */
    public function fetchAll(): CollectionInterface
    {
        $postCollection = new PostCollection();

        // fetch post page by page and store in object
        for ($page = 1; $page <= 10; $page++) {
            // request to Supermetrics API Endpoint
            $postItems = $this->fetch($page);

            // each page add to post collection
            $postCollection->add($postItems);
        }

        return $postCollection;
    }

    /**
     * Fetch posts
     * @param int $page
     * @return array|null
     */
    protected function fetch(int $page = 1): ?array
    {
        $url = '/posts';
        $token = $this->session->get($this->getConfig('SUPERMETRICS_TOKEN_NAME'))['token'];

        try {
            $response = $this->httpClient->get($url, [
                'sl_token' => $token,
                'page' => $page
            ]);
        } catch (Throwable $e) {
            throw new HttpResponseException($e->getMessage(), $e->getCode());
        }

        if ($response->getStatusCode() !== 200) {
            throw new HttpResponseException($this->httpClient->getBaseUrl() . $url . ' ' .
                $response->getBody()['error']['message'], $response->getStatusCode());
        }

        return $response->getBody()['data']['posts'];
    }

    /**
     * Get stat of post by filters
     * @param CollectionInterface $posts
     * @return JsonResponse
     */
    public function getStatistics(CollectionInterface $posts): JsonResponse
    {
        $aggregator = new Aggregator();

        $aggregator->add(new AverageCharLenPerMonth);
        $aggregator->add(new LongestPostByCharLenPerMonth);
        $aggregator->add(new TotalPostByWeek);
        $aggregator->add(new AveragePostCountPerUserPerMonth);

        return (new JsonResponse($aggregator->handle($posts)));
    }
}