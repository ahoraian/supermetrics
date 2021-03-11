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
        $this->httpClient = $configs['httpClient'];
        $this->session = $configs['session'];
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