<?php declare(strict_types=1);

namespace App\Services\Common\HttpClients;

class ArrayResponse extends AbstractResponse
{
    /**
     * Turn json string response to array
     * @return array|null
     */
    public function getBody() : ?array
    {
        return json_decode($this->body, true, flags: JSON_THROW_ON_ERROR);
    }
}