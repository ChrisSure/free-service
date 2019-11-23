<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Exceptions\NotAllowException;
use App\Exceptions\UniqueException;
use App\Repository\User\UserRepository;
use App\Service\Email\MailService;
use App\Service\Helpers\PasswordHashService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @var JwtService
     */
    private $jwtService;

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PasswordHashService $passService, JwtService $jwtService, MailService $mailService, UserRepository $userRepository)
    {
        $this->passService = $passService;
        $this->jwtService = $jwtService;
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
        $userUnique = $user = $this->userRepository->findOneBy(['email' => $data['email']]);
        if ($userUnique)
            throw new UniqueException("User who has that email already isset.");

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
     * Confirm registration user
     * @param array $data
     * @return void
     */
    public function confirmUser(array $data): void
    {
        $user = $this->userRepository->findOneBy([
            'id' => $data['id'],
            'token' => $data['token']
        ]);
        if (!$user)
            throw new NotFoundHttpException('You have missed data.');

        $user->setStatus('active');
        $user->setToken(null);
        $user->onPreUpdate();
        $this->userRepository->save($user);
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
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setToken($token)->onPreUpdate();
        $this->userRepository->save($user);

        $this->mailService->sendForgetPassword($user, $token);
    }

    /**
     * Check user token
     * @param array $data
     * @return void
     */
    public function checkUserToken(array $data): void
    {
        $user = $this->userRepository->findOneBy([
            'id' => $data['id'],
            'token' => $data['token']
        ]);
        if (!$user)
            throw new NotFoundHttpException('You have missed data.');

        $user->setToken(null);
        $user->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Set new password
     * @param array $data
     * @param int $id
     * @return void
     */
    public function setNewPassword(array $data, $id): void
    {
        $user = $this->userRepository->find($id);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setPassword($this->passService->hashPassword($user, $data['password']))
            ->setToken(null)->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Login user
     * @param array $data
     * @return string
     */
    public function loginUser(array $data): string
    {
        $user = $this->checkCredentials($data);
        return $this->jwtService->createToken($user);
    }

    /**
     * Check user credentials
     * @param array $data
     * @return User
     * @throws NotAllowException
     */
    private function checkCredentials(array $data): User
    {
        $user = $this->userRepository->findOneBy(['email' => $data['email']]);

        if (!$user || !$this->passService->checkPassword($data['password'], $user))
            throw new NotFoundHttpException('You have entered mistake login or password.');

        if ($user->getStatus() != 'active')
            throw new NotAllowException('You didn\'t accept your email.');

        return $user;
    }

}