<?php

namespace App\Repository\Data;

use App\Entity\Data\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    /**
     * Get user
     * @param $id
     * @return Region
     */
    public function get($id): Region
    {
        $region = $this->find($id);
        if (!$region)
            throw new NotFoundHttpException('Region doesn\'t exist.');
        return $region;
    }

    /**
     * Save region
     * @param Region $region
     * @return void
     */
    public function save(Region $region): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($region);
        $entityManager->flush();
    }

    /**
     * Remove region
     * @param Region $region
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Region $region)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($region);
        $entityManager->flush();
    }
}
