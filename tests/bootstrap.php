<?php declare(strict_types=1);

namespace App\Tests;

use App\Services\Common\HttpClients\CurlClient;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Register The Auto Loader
 */
require_once __DIR__ . '/../vendor/autoload.php';


/**
 * Load Configuration from .env
 */
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// start session when set configuration SESSION_DRIVER=Session
if (env('SESSION_DRIVER') == 'Session') {
    session_start();
}