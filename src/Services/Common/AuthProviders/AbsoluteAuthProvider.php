<?php

namespace App\Services\Common\AuthProviders;

use App\Services\Common\Config\ConfigInterface;
use App\Services\Common\HttpClients\HttpClientInterface;
use App\Services\Common\Session\SessionInterface;

abstract class AbsoluteAuthProvider implements AuthProviderInterface
{
    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * @var SessionInterface
     */
    protected SessionInterface $session;

    /**
     * Set session driver [Session | File | Redis | Memcached | ...]
     * Supermetrics constructor.
     * @param ConfigInterface $configs
     */
    public function __construct(protected ConfigInterface $configs)
    {
        $this->session = $configs['sessionDriver'];
        $this->httpClient = $configs['httpClient'];
    }

    /**
     * @param string $key
     * @return string|null
     */
    protected function getConfig(string $key): ?string
    {
        return $this->configs->get($key);
    }
}