<?php

namespace App\Repository\Data;

use App\Entity\Data\City;
use App\Entity\Data\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
     * Get city
     * @param $id
     * @return City
     */
    public function get($id): City
    {
        $city = $this->find($id);
        if (!$city)
            throw new NotFoundHttpException('City doesn\'t exist.');
        return $city;
    }

    /**
     * Get list cities
     * @param array|null $filter
     * @return array
     */
    public function getAll(array $filter = null): array
    {
        $db = $this->createQueryBuilder('c');

        if ($filter != null) {
            if (array_key_exists('name', $filter) && $filter['name'] != "") {
                $db->andWhere('c.name LIKE :name')->setParameter('name', "%".$filter['name']."%");
            }
            if (array_key_exists('region', $filter) && $filter['region'] != "") {
                $db->andWhere('c.region = :region')->setParameter('region', $filter['region']);
            }
        }

        return $db->getQuery()->getResult();
    }

    /**
     * Save city
     * @param City $city
     * @return void
     */
    public function save(City $city): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($city);
        $entityManager->flush();
    }

    /**
     * Remove region
     * @param City $city
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(City $city)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($city);
        $entityManager->flush();
    }
}
