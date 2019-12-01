<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 13:46
 */

namespace App\Service\Auth;

use App\Dto\User\TokenDto;
use App\Entity\User\User;
use App\Exceptions\NotAllowException;
use App\Exceptions\TokenException;
use App\Exceptions\UniqueException;
use App\Repository\User\UserRepository;
use App\Service\Email\MailService;
use App\Service\Helpers\PasswordHashService;
use App\Service\Helpers\SerializeService;
use App\Service\Helpers\TokenService;
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

    /**
     * @var SerializeService
     */
    private $serialize;

    /**
     * @var TokenService
     */
    private $tokenService;


    public function __construct(PasswordHashService $passService, JwtService $jwtService, MailService $mailService, UserRepository $userRepository, TokenService $tokenService, SerializeService $serialize)
    {
        $this->passService = $passService;
        $this->jwtService = $jwtService;
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
        $this->serialize = $serialize;
        $this->tokenService = $tokenService;
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
        $token = $this->tokenService->generateToken();
        $user
            ->setEmail($data['email'])
            ->setPassword($this->passService->hashPassword($user, $data['password']))
            ->setRoles([User::$ROLE_USER])
            ->setStatus(User::$STATUS_NEW)
            ->setToken($this->serialize->serialize($token))
            ->onPrePersist()->onPreUpdate();
        $this->userRepository->save($user);
        $this->mailService->sendCheckRegistration($user, $token->getToken());
    }

    /**
     * Confirm registration user
     * @param array $data
     * @param int $id
     * @return void
     */
    public function confirmUser(array $data, $id): void
    {
        $user = $this->userRepository->get($id);
        $tokenObject = $this->serialize->deserialize($user->getToken(), TokenDto::class, 'json');

        if ($tokenObject->getToken() != $data['token']) {
            throw new TokenException('You have missed data.');
        }
        if ($tokenObject->getExpired() <= time()) {
            throw new TokenException('Token time has overed.');
        }

        $user->setStatus(User::$STATUS_ACTIVE);
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
        $user = $this->userRepository->getByEmail($data['email']);
        if ($user->getToken() != null) {
            throw new TokenException('You change your password too often.');
        }

        $token = $this->tokenService->generateToken();

        $user->setToken($this->serialize->serialize($token))->onPreUpdate();
        $this->userRepository->save($user);

        $this->mailService->sendForgetPassword($user, $token->getToken());
    }

    /**
     * Check user token
     * @param array $data
     * @param int $id
     * @return void
     */
    public function checkUserToken(array $data, $id): void
    {
        $user = $this->userRepository->get($id);
        $tokenObject = $this->serialize->deserialize($user->getToken(), TokenDto::class, 'json');

        if ($tokenObject->getToken() != $data['token']) {
            throw new NotAllowException('You have missed data.');
        }
        if ($tokenObject->getExpired() <= time()) {
            throw new NotAllowException('Token time has overed.');
        }

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
        $user = $this->userRepository->get($id);
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

        if ($user->getStatus() != User::$STATUS_ACTIVE)
            throw new NotAllowException('You didn\'t accept your email.');

        return $user;
    }

}