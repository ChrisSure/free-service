<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthService
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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

    /**
     * Hash password
     * @param User $user
     * @param string $password
     * @return string
     */
    public function hashPassword(User $user, $password): string
    {
        return $this->encoder->encodePassword($user, $password);
    }

}