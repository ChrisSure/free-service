<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Service\Email\MailService;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthService
{
    private $encoder;
    private $mailService;
    private $userRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, MailService $mailService, UserRepository $userRepository)
    {
        $this->encoder = $encoder;
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
    }

    /**
     * Get user by token, id
     * @param array $data
     * @return void
     */
    public function registerUser(array $data): void
    {
        $user = new User();
        $token = $this->generateToken();
        $user
            ->setEmail($data['email'])
            ->setPassword($this->hashPassword($user, $data['password']))
            ->setRoles(['ROLE_USER'])
            ->setStatus('new')
            ->setToken($token)
            ->onPrePersist()->onPreUpdate();
        $this->userRepository->save($user);
        $this->mailService->sendCheckRegistration($user, $token);
    }

    /**
     * Forget user password
     * @param array $data
     * @return void
     */
    public function forgetPassword(array $data): void
    {
        $token = $this->generateToken();

        $user = $this->userRepository->findOneBy([
            'email' => $data['email']
        ]);
        $user->setToken($token)->onPreUpdate();
        $this->userRepository->save($user);

        $this->mailService->sendForgetPassword($user, $token);
    }

    /**
     * Set new password
     * @param array $data
     * @return void
     */
    public function setNewPassword(array $data): void
    {
        $user = $this->userRepository->find($data['id']);
        $user->setPassword($this->hashPassword($user, $data['password']))->setToken(null)->onPreUpdate();
        $this->userRepository->save($user);
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