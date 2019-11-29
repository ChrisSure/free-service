<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 28.11.19
 * Time: 10:16
 */

namespace App\Service\Data;

use App\Entity\Data\Region;
use App\Repository\Data\RegionRepository;
use App\Service\Helpers\SerializeService;


class RegionService
{
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
    public function __construct(RegionRepository $regionRepository, SerializeService $serializeService)
    {
        $this->regionRepository = $regionRepository;
        $this->serializeService = $serializeService;
    }

    /**
     * Get list regions (serialize)
     * @return string
     */
    public function getRegions(): string
    {
        return $this->serializeService->serialize($this->regionRepository->findAll());
    }
}