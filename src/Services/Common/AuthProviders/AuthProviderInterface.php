<?php declare(strict_types=1);

namespace App\Services\Common\AuthProviders;

interface AuthProviderInterface
{
    /**
     * Request for token or read from cache [Session|File|...]
     * @return string|null
     */
    public function getToken() : ?string;

    /**
     * @param array $tokenData
     * @return mixed
     */
    public function isValid(array $tokenData) : bool;
}