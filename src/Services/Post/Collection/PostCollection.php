<?php declare(strict_types=1);

namespace App\Services\Post\Collection;

use App\Entities\Post;
use App\Services\Common\Collections\CollectionInterface;
use Closure;

class PostCollection implements CollectionInterface
{
    /**
     * @var array
     */
    private array $posts = [];

    /**
     * Add a collection of posts
     * @param array $list
     * @return void
     */
    public function add(array $list) : void
    {
        foreach ($list as $post) {
            array_push($this->posts,
                new Post([
                    'id' => $post['id'],
                    'from_name' => $post['from_name'],
                    'from_id' => $post['from_id'],
                    'message' => $post['message'],
                    'type' => $post['type'],
                    'created_time' => date_create($post['created_time'])
                ])
            );
        }
    }

    /**
     * Return Count of elements
     * @return int
     */
    public function count(): int
    {
        return count($this->posts);
    }

    /**
     * Map collection
     * @param Closure $closure
     * @return array
     */
    public function map(Closure $closure): array
    {
        return array_map($closure, $this->posts);
    }

    /**
     * Return all elements
     * @return array
     */
    public function all(): array
    {
        return $this->posts;
    }
}