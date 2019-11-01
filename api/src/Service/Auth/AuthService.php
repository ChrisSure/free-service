<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Service\AbstractService;
use App\Service\Email\MailService;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthService extends AbstractService
{
    private $encoder;
    private $mailService;

    public function __construct(UserPasswordEncoderInterface $encoder, MailService $mailService)
    {
        $this->encoder = $encoder;
        $this->mailService = $mailService;
    }

    /**
     * Get user by token, id
     * @param array $data
     * @return void
     */
    public function registerUser(array $data): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $token = $this->generateToken();
        $user
            ->setEmail($data['email'])
            ->setPassword($this->hashPassword($user, $data['password']))
            ->setRoles(($data['role'] == 'worker') ? ['ROLE_WORKER'] : ['ROLE_USER'])
            ->setStatus('new')
            ->setToken($token)
            ->onPrePersist()->onPreUpdate();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->mailService->sendCheckRegistration($user, $token);
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

}