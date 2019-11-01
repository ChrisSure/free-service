<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.11.19
 * Time: 9:50
 */

namespace App\Service\User;

use App\Entity\User\User;
use App\Service\AbstractService;


class UserService extends AbstractService
{
    /**
     * Get user by token, id
     * @param int $id
     * @param string $token
     * @return ?User
     */
    public function getUserByTokenId($id, $token): ?User
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        return $repository->findOneBy([
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
        $entityManager = $this->getDoctrine()->getManager();
        $user2 = $entityManager->getRepository(User::class)->find($id);
        $user2->setStatus('active');
        $user2->setToken(null);
        $entityManager->persist($user2);
        $entityManager->flush();
    }

}