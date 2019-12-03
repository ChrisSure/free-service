<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.12.19
 * Time: 9:48
 */

namespace App\Service\Helpers;

use App\Dto\User\TokenDto;


class TokenService
{
    /**
     * Generate string token
     * @return TokenDto
     */
    public function generateToken(): TokenDto
    {
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $expired = time() + (60 * 15);
        return new TokenDto($token, $expired);
    }
}