<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 28.11.19
 * Time: 10:13
 */

namespace App\Controller\Data;

use App\Service\Data\RegionService;
use App\Service\Helpers\SerializeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/region")
 */
class RegionController extends AbstractController
{
    /**
     * @var RegionService
     */
    private $regionService;

    /**
     * RegionController constructor.
     * @param RegionService $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;

    }

    /**
     * Get list regions
     * @Route("/", name="region_get_all",  methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getRegions(Request $request): Response
    {
        try {
            $regions = $this->regionService->getRegions();
            return new Response($regions, 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }
}