<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Entity\User\User;


class AuthService
{

    /**
     * Generate string token
     * @return string
     */
    public function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * Delegate to email service send check registration
     * @param User $user
     * @param string $token
     * @return string
     */
    public function sendCheckRegistration(User $user, $token)
    {

    }

}