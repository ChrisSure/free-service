<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Get user
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        $user = $this->find($id);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');
        return $user;
    }

    /**
     * Get user by email
     * @param $email
     * @return User
     */
    public function getByEmail($email): User
    {
        $user = $this->findOneBy([
            'email' => $email
        ]);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');
        return $user;
    }

    /**
     * Get user by token
     * @param array $data
     * @return User
     */
    public function getByToken(array $data): User
    {
        $user = $this->findOneBy([
            'id' => $data['id'],
            'token' => $data['token']
        ]);
        if (!$user)
            throw new NotFoundHttpException('You have missed data.');
        return $user;
    }

    /**
     * Save user
     * @param User $user
     * @return void
     */
    public function save(User $user): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    /**
     * Get user that email can not be params email and id can be user->id
     * @param array $data
     * @param int $id
     * @return array
     */
    public function GetUserByEmailAndLikeId(array $data, $id): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.id != :id')->andWhere('u.email = :email')
            ->setParameter('id', $id)
            ->setParameter('email', $data['email']);
        return $qb->getQuery()
            ->getResult();
    }



}
