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

/**
 * Class AdminService
 * @package App\Service\User
 */
class AdminService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AdminService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all admins
     * @param $sort
     * @param array|null $filter
     * @return array
     */
    public function getAll($sort, array $filter = null): array
    {
        return $this->userRepository->findAllAdmin($sort, $filter);
    }

    /**
     * Get admin
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        return $this->userRepository->get($id);
    }


}