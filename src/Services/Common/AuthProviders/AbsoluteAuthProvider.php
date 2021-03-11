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
        $this->session = $configs->get('sessionDriver');
        $this->httpClient = $configs->get('httpClient');
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getConfig(string $key): mixed
    {
        return $this->configs->get($key);
    }
}