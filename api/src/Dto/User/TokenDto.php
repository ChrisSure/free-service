<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.12.19
 * Time: 9:26
 */

namespace App\Dto\User;


class TokenDto
{
    private $token;

    private $expired;

    public function __construct($token, $expired)
    {
        $this->token = $token;
        $this->expired = $expired;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getExpired(): int
    {
        return $this->expired;
    }

}