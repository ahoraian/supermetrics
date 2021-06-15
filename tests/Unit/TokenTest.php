<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Common\AuthProviders\Supermetrics;
use App\Services\Common\Config\Config;
use App\Services\Common\HttpClients\CurlClient;
use App\Services\Common\Session\ArrayDriver;
use App\Services\Common\Session\SessionDriver;
use PHPUnit\Framework\TestCase;
use Throwable;

class TokenTest extends TestCase
{
    /**
     * @var CurlClient
     */
    private CurlClient $client;

    /**
     * @var SessionDriver
     */
    private SessionDriver $sessionDriver;

    /**
     * @var Config
     */
    private Config $configs;

    /**
     * Initial values
     */
    protected function setUp(): void
    {
        /**
         * Load app configs
         */
        $this->configs = new Config($_ENV);

        /**
         * Set Session Driver
         */
        $this->configs->put('sessionDriver', new ArrayDriver);

        /**
         * Create a http client
         */
        $this->configs->put('httpClient', new CurlClient($this->configs->get('API_ENDPOINT')));
    }

    /**
     * Test get response
     * @throws Throwable
     */
    public function testResponse()
    {
        $token = (new Supermetrics($this->configs))
            ->getToken();

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }
}