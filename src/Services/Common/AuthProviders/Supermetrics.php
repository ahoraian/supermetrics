<?php declare(strict_types=1);

namespace App\Services\Common\AuthProviders;

use App\Services\Common\Exceptions\HttpResponseException;
use Throwable;

class Supermetrics extends AbsoluteAuthProvider
{
    /**
     * Request for get token
     * @return string|null
     */
    public function getToken(): ?string
    {
        $tokenData = [];

        // check for token already exists
        $sessionKey = $this->getConfig('SUPERMETRICS_TOKEN_NAME');
        if ($this->session->has($sessionKey)) {
            $tokenData = $this->session->get($sessionKey);
        }

        // when session is not valid or not exists request for new token
        if (!($tokenData && $this->isValid($tokenData))) {

            // try to connect api endpoint and fetch result else throw an exception
            try {
                $response = $this->httpClient->post('/register', [
                    'client_id' => $this->getConfig('SUPERMETRICS_CLIENT_ID'),
                    'email' => $this->getConfig('SUPERMETRICS_EMAIL'),
                    'name' => $this->getConfig('SUPERMETRICS_NAME')
                ]);

                $data = $response->getBody()['data'];

                // put new token in session driver [e.g: File|Session|...]
                // lifetime in minutes
                $tokenLifetime = $this->getConfig('SUPERMETRICS_TOKEN_LIFETIME');
                $tokenData = [
                    'token' => $data['sl_token'],
                    'expireAt' => strtotime("+{$tokenLifetime} minutes")
                ];

                // cached the token data
                $this->session->put($sessionKey, $tokenData);
            } catch (Throwable $e) {
                throw new HttpResponseException($e->getMessage(), $e->getCode());
            }
        }

        return $tokenData['token'];
    }

    /**
     * Check token is valid
     * @param array $tokenData
     * @return bool
     */
    public function isValid(array $tokenData): bool
    {
        if ($tokenData['expireAt'] < time()) {
            return false;
        }

        return true;
    }
}