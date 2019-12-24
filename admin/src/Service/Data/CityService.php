<?php

namespace App\Service\Data;

use App\Entity\Data\City;
use App\Repository\Data\CityRepository;
use App\Repository\Data\RegionRepository;

/**
 * Class CityService
 * @package App\Service\Data
 */
class CityService
{
    private $cityRepository;

    private $regionRepository;

    public function __construct(CityRepository $cityRepository, RegionRepository $regionRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->regionRepository = $regionRepository;
    }

    /**
     * Get all regions
     * @return City[]
     */
    public function getAll(): array
    {
        return $this->cityRepository->findAll();
    }

    /**
     * Get city
     * @param $id
     * @return City
     */
    public function get($id): City
    {
        return $this->cityRepository->get($id);
    }

    /**
     * Save create region
     * @param City $city
     */
    public function save(City $city): void
    {
        $this->cityRepository->save($city);
    }

    /**
     * Remove region
     * @param City $city
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(City $city): void
    {
        $this->cityRepository->remove($city);
    }
}