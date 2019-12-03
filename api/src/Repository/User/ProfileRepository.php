<?php

namespace App\Repository\User;

use App\Entity\User\Profile;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Get profile
     * @param $id
     * @return Profile
     */
    public function get($id): Profile
    {
        $profile = $this->find($id);
        if (!$profile)
            throw new NotFoundHttpException('Profile doesn\'t exist.');
        return $profile;
    }

    /**
     * Get profile by user id
     * @param User $user
     * @return Profile
     */
    public function getByUser(User $user): Profile
    {
        $profile = $this->findOneBy(['user' => $user]);
        if (!$profile)
            throw new NotFoundHttpException('Profile doesn\'t exist.');
        return $profile;
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
