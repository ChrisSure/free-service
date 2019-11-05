<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.11.19
 * Time: 9:50
 */

namespace App\Service\User;

use App\Entity\User\User;
use App\Exceptions\NotAllowException;
use App\Exceptions\UniqueException;
use App\Repository\User\UserRepository;
use App\Service\Helpers\PasswordashService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserService
 * @package App\Service\User
 */
class UserService
{
    /**
     * @var PasswordashService
     */
    private $passService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PasswordashService $passService, UserRepository $userRepository)
    {
        $this->passService = $passService;
        $this->userRepository = $userRepository;
    }

    /**
     * Get user by token, id
     * @param int $id
     * @param string $token
     * @return ?User
     */
    public function getUserByTokenId($id, $token): ?User
    {
        return $this->userRepository->findOneBy([
            'id' => $id,
            'token' => $token
        ]);
    }

    /**
     * Change user status and clear token
     * @param int $id
     * @return void
     */
    public function changeUserActiveStatus($id): void
    {
        $user = $this->userRepository->find($id);
        $user->setStatus('active');
        $user->setToken(null);
        $this->userRepository->save($user);
    }

    /**
     * Change user email
     * @param array $data
     * @param int $current_user_id
     * @return void
     */
    public function changeEmail(array $data, $current_user_id): void
    {
        if ($current_user_id != $data['id']) {
            throw new NotAllowException('You don\'t allow this action.');
        }

        $check_email = $this->userRepository->GetUserByEmailAndLikeId($data);
        if ($check_email)
            throw new UniqueException('That email have already used.');

        $user = $this->userRepository->find($data['id']);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setEmail($data['email'])->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Change user password
     * @param array $data
     * @param int $current_user_id
     * @return void
     */
    public function changePassword(array $data, $current_user_id): void
    {
        if ($current_user_id != $data['id']) {
            throw new NotAllowException('You don\'t allow this action.');
        }

        $user = $this->userRepository->find($data['id']);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setPassword($this->passService->hashPassword($user, $data['password']))->onPreUpdate();
        $this->userRepository->save($user);
    }

}