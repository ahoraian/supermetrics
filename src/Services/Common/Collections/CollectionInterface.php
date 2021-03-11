<?php declare(strict_types=1);

namespace App\Services\Common\Collections;

use Closure;

interface CollectionInterface
{
    /**
     * Add a collection of posts
     * @param array $list
     */
    public function add(array $list): void;

    /*
     * Return all items
     *
     * @return array
     * */
    public function all(): array;

    /*
     * map on each items by sending a callback
     *
     * @return array
     * */
    /**
     * @param Closure $closure
     * @return array
     */
    public function map(Closure $closure): array;

    /*
     * Return count
     *
     * @return int
     * */
    public function count(): int;
}