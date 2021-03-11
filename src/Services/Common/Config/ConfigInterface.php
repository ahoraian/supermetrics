<?php declare(strict_types=1);

namespace App\Services\Common\Config;

interface ConfigInterface
{
    /**
     * @param $key
     * @return string|null
     */
    public function get(string $key) : ?string;

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function put(string $key, mixed $value) : void;
}