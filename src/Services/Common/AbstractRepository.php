<?php

namespace App\Services\Common;

use App\Services\Common\Config\ConfigInterface;
use App\Services\Common\HttpClients\HttpClientInterface;
use App\Services\Common\Session\SessionInterface;

class AbstractRepository
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
     * Post constructor.
     * @param ConfigInterface $configs
     */
    public function __construct(protected ConfigInterface $configs)
    {
        $this->httpClient = $configs->get('httpClient');
        $this->session = $configs->get('sessionDriver');
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