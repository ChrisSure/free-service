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
use App\Service\Helpers\PasswordHashService;
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

    public function __construct(PasswordHashService $passService, UserRepository $userRepository)
    {
        $this->passService = $passService;
        $this->userRepository = $userRepository;
    }

    /**
     * Change user email
     * @param array $data
     * @param int $id
     * @param int $current_user_id
     * @return void
     */
    public function changeEmail(array $data, $id, $current_user_id): void
    {
        $check_email = $this->userRepository->GetUserByEmailAndLikeId($data, $id);
        if ($check_email)
            throw new UniqueException('That email have already used.');

        $user = $this->userRepository->find($id);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setEmail($data['email'])->onPreUpdate();
        $this->userRepository->save($user);
    }

    /**
     * Change user password
     * @param array $data
     * @param int $id
     * @param int $current_user_id
     * @return void
     */
    public function changePassword(array $data, $id, $current_user_id): void
    {
        $user = $this->userRepository->find($id);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $user->setPassword($this->passService->hashPassword($user, $data['password']))->onPreUpdate();
        $this->userRepository->save($user);
    }

}