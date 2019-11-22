<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 21.11.19
 * Time: 12:44
 */

namespace App\Repository\User;

use App\Entity\User\SocialUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SocialUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialUser[]    findAll()
 * @method SocialUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialUser::class);
    }
}