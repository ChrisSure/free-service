<?php

namespace App\Repository\User;

use App\Entity\User\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }


    /**
     * Save profile
     * @param Profile $profile
     * @return void
     */
    public function save(Profile $profile): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($profile);
        $entityManager->flush();
    }
}
