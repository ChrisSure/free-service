<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 02.12.19
 * Time: 10:33
 */
namespace App\Service\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Service\Helpers\PasswordHashService;

/**
 * Class UserService
 * @package App\Service\User
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordHashService
     */
    private $passService;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, PasswordHashService $passService)
    {
        $this->userRepository = $userRepository;
        $this->passService = $passService;
    }

    /**
     * Get all users
     * @param $sort
     * @param array|null $filter
     * @return array
     */
    public function getAll($sort, array $filter = null): array
    {
        return $this->userRepository->getAll($sort, $filter);
    }

    /**
     * Get user
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        return $this->userRepository->get($id);
    }

    /**
     * Create user
     * @param array $data
     */
    public function createUser(array $data): void
    {
        $user = new User();
        $user
            ->setEmail($data['email'])
            ->setPassword($this->passService->hashPassword($user, $data['password']))
            ->setRoles([$data['role']])
            ->setStatus(User::$STATUS_ACTIVE)
            ->onPrePersist()->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Change role user
     * @param User $user
     * @param array $data
     */
    public function changeRole(User $user, array $data): void
    {
        $user->setRoles([$data['role']])->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Block user
     * @param User $user
     */
    public function blockUser(User $user): void
    {
        $user->setStatus(User::$STATUS_BLOCKED)->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Unblock user
     * @param User $user
     */
    public function unblockUser(User $user): void
    {
        $user->setStatus(User::$STATUS_ACTIVE)->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Remove user
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(User $user): void
    {
        $this->userRepository->remove($user);
    }


}