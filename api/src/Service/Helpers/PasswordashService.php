<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 14:04
 */

namespace App\Service\Helpers;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class PasswordashService
 * @package App\Service\Helpers
 */
class PasswordashService
{
    /**
     * @var UserPasswordEncoderInterface
     */
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
     * Hash password
     * @param User $user
     * @param string $password
     * @return string
     */
    public function hashPassword(User $user, $password): string
    {
        return $this->encoder->encodePassword($user, $password);
    }

    /**
     * Check user password
     * @param $password
     * @param UserInterface $user
     * @return bool
     */
    public function checkPassword($password, UserInterface $user)
    {
        return $this->encoder->isPasswordValid($user, $password);
    }
}