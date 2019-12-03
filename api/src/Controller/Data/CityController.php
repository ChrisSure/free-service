<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 28.11.19
 * Time: 10:13
 */

namespace App\Controller\Data;

use App\Service\Data\CityService;
use App\Service\Helpers\SerializeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @var CityService
     */
    private $cityService;

    /**
     * CityController constructor.
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;

    }

    /**
     * Get list cities by region_id
     * @Route("/{region_id}", name="city_get_by_region_id",  methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getCitiesByRegionId(Request $request): Response
    {
        try {
            $regions = $this->cityService->getCitiesByRegionId($request->get('region_id'));
            return new Response($regions, 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }
}