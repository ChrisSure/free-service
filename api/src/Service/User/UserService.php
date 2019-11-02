<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.11.19
 * Time: 9:50
 */

namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;


class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
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

}