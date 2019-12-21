<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
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
     * Return list of users with filtration and sortable
     * @param string $sort
     * @param array $filter|null
     * @return mixed
     */
    public function getAll($sort, array $filter = null): array
    {
        $sort = ($sort == 'asc') ? 'ASC' : 'DESC';
        $db = $this->createQueryBuilder('u')->orderBy('u.created_at', $sort);

        if ($filter != null) {
            if (array_key_exists('email', $filter) && $filter['email'] != "") {
                $db->andWhere('u.email LIKE :email')->setParameter('email', "%".$filter['email']."%");
            }
            if (array_key_exists('status', $filter) && $filter['status'] != "") {
                $db->andWhere('u.status = :status')->setParameter('status', $filter['status']);
            }
            if (array_key_exists('role', $filter) && $filter['role'] != "") {
                $db->andWhere('u.roles LIKE :role')->setParameter('role', '%"'.$filter['role'].'"%');
            }
        }

        return $db->getQuery()->getResult();
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
     * Remove user
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(User $user)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($user);
        $entityManager->flush();
    }

}
