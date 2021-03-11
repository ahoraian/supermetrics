<?php declare(strict_types=1);

namespace App\Tests\Unit;

use App\Services\Common\AuthProviders\Supermetrics;
use App\Services\Common\HttpClients\CurlClient;
use App\Services\Common\Session\Session;
use PHPUnit\Framework\TestCase;
use Throwable;

class GetTokenTestTest extends TestCase
{
    /**
     * @var CurlClient
     */
    private CurlClient $client;

    /**
     * @var Session
     */
    private Session $sessionDriver;

    /**
     * Initial values
     */
    protected function setUp(): void
    {
        /**
         * Create a http client
         */
        $this->client = new CurlClient(env('API_ENDPOINT'));

        // start session when set configuration SESSION_DRIVER=Session
        if (env('SESSION_DRIVER') == 'Session') {
            $this->sessionDriver = new Session();
        }
    }

    /**
     * Test get response
     * @throws Throwable
     */
    public function testResponse()
    {
        $token = (new Supermetrics($this->client, $this->sessionDriver))
            ->getToken();

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }
}