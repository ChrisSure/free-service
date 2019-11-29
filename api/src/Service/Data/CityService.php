<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 28.11.19
 * Time: 10:16
 */

namespace App\Service\Data;

use App\Entity\Data\Region;
use App\Repository\Data\CityRepository;
use App\Repository\Data\RegionRepository;
use App\Service\Helpers\SerializeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CityService
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var RegionRepository
     */
    private $regionRepository;

    /**
     * @var SerializeService
     */
    private $serializeService;

    /**
     * RegionService constructor.
     * @param RegionRepository $regionRepository
     */
    public function __construct(CityRepository $cityRepository, RegionRepository $regionRepository, SerializeService $serializeService)
    {
        $this->cityRepository = $cityRepository;
        $this->regionRepository = $regionRepository;
        $this->serializeService = $serializeService;
    }

    /**
     * Get list cities by region_id (serialize)
     * @param int $region_id
     * @return string
     */
    public function getCitiesByRegionId($region_id): string
    {
        $region = $this->regionRepository->find($region_id);
        if (!$region)
            throw new NotFoundHttpException('Region doesn\'t exist.');

        return $this->serializeService->serialize($this->cityRepository->findBy(['region' => $region]));
    }
}