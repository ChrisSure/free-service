<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 19.11.19
 * Time: 13:38
 */

namespace App\Service\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JwtService
 * @package App\Service\Auth
 */
class JwtService
{
    /**
     * @var JWTTokenManagerInterface
     */
    private $JWTManager;

    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    /**
     * Create jwt token
     * @param UserInterface $user
     * @return string
     */
    public function createToken(UserInterface $user): string
    {
        return $this->JWTManager->create($user);
    }
}