<?php declare(strict_types=1);

namespace App\Services\Common\Config;

interface ConfigInterface
{
    /**
     * Return specific config value
     * @param $key
     * @return mixed
     */
    public function get(string $key) : mixed;

    /**
     * Put specific config item
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put(string $key, mixed $value) : void;

    /**
     * Return all configs
     * @return array
     */
    public function all() : array;
}