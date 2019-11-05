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
use App\Service\Helpers\PasswordashService;

/**
 * Class AuthService
 * @package App\Service\Auth
 */
class AuthService
{
    /**
     * @var PasswordashService
     */
    private $passService;

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PasswordashService $passService, MailService $mailService, UserRepository $userRepository)
    {
        $this->passService = $passService;
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
        $token = $this->passService->generateToken();
        $user
            ->setEmail($data['email'])
            ->setPassword($this->passService->hashPassword($user, $data['password']))
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
        $token = $this->passService->generateToken();

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
        $user->setPassword($this->passService->hashPassword($user, $data['password']))->setToken(null)->onPreUpdate();
        $this->userRepository->save($user);
    }

}