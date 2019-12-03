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
     * Return list of admins with filtration and sortable
     * @param string $sort
     * @param array $filter|null
     * @return mixed
     */
    public function findAllAdmin($sort, array $filter = null): array
    {
        $sort = ($sort == 'asc') ? 'ASC' : 'DESC';
        $db = $this->createQueryBuilder('u')
            ->where('u.roles LIKE :roleModer')->orWhere('u.roles LIKE :roleAdmin')->orWhere('u.roles LIKE :roleSAdmin')
            ->setParameter('roleModer', '%"'.User::$ROLE_MODERATOR.'"%')
            ->setParameter('roleAdmin', '%"'.User::$ROLE_ADMIN.'"%')
            ->setParameter('roleSAdmin', '%"'.User::$ROLE_SUPER_ADMIN.'"%')
            ->orderBy('u.created_at', $sort);

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

}
