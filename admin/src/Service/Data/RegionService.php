<?php

namespace App\Service\Data;

use App\Entity\Data\Region;
use App\Repository\Data\RegionRepository;

class RegionService
{
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * Get all regions
     * @return Region[]
     */
    public function getAll(): array
    {
        return $this->regionRepository->findAll();
    }

    /**
     * Get region
     * @param $id
     * @return Region
     */
    public function get($id): Region
    {
        return $this->regionRepository->get($id);
    }

    /**
     * Save (create, update) region
     * @param Region $region
     */
    public function save(Region $region): void
    {
        $this->regionRepository->save($region);
    }

    /**
     * Remove region
     * @param Region $region
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Region $region): void
    {
        $this->regionRepository->remove($region);
    }

}