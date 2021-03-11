<?php declare(strict_types=1);

// check application speed (with large array)
$startTime = microtime(true);

use Symfony\Component\Dotenv\Dotenv;
use App\Services\Common\Config\Config;
use App\Services\Post\PostRepository;
use App\Services\Common\Session\Session;
use App\Services\Common\HttpClients\CurlClient;
use App\Services\Common\AuthProviders\Supermetrics;
use \App\Services\Common\Exceptions\HttpResponseException;

/**
 * Register The Auto Loader
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv;
$dotenv->load(__DIR__ . '/../.env');

/**
 * Load app configs
 */
$configs = new Config($_ENV);

// start session when set configuration SESSION_DRIVER=Session
$sessionDriver = null;
if ($configs->get('SESSION_DRIVER') == 'Session') {
    session_start();
    $configs->put('sessionDriver', new Session);
}

/**
 * Create a http client
 */
$configs->put('httpClient', new CurlClient($configs->get('API_ENDPOINT')));

/**
 * Get Token form Supermetrics api
 * Cached the token for 1 hour
 */
(new Supermetrics($configs))->getToken();

/**
 * Inject $httpClient into posts and fetch posts
 */
$post = new PostRepository($configs);
try {
    $posts = $post->fetchAll();
} catch (Throwable $e) {
    throw new HttpResponseException($e->getMessage(), $e->getCode());
};

/**
 * Statistics
 */
echo $post->getStatistics($posts);