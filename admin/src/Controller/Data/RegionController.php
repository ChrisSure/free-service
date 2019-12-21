<?php

namespace App\Controller\Data;

use App\Entity\Data\Region;
use App\Form\Data\RegionType;
use App\Repository\Data\RegionRepository;
use App\Service\Data\RegionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/data/region")
 */
class RegionController extends AbstractController
{
    private $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * @Route("/", name="data_region_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/data/region/index.html.twig', [
            'regions' => $this->regionService->getAll(),
        ]);
    }

    /**
     * @Route("/new", name="data_region_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $region = new Region();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->regionService->save($region);
            $this->addFlash('success', 'Region has created.');
            return $this->redirectToRoute('data_region_index');
        }

        return $this->render('admin/data/region/new.html.twig', [
            'region' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="data_region_show", methods={"GET"})
     */
    public function show($id): Response
    {
        return $this->render('admin/data/region/show.html.twig', [
            'region' => $this->regionService->get($id),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="data_region_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Region $region): Response
    {
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->regionService->save($region);
            $this->addFlash('success', 'Region has updated.');
            return $this->redirectToRoute('data_region_index');
        }

        return $this->render('admin/data/region/edit.html.twig', [
            'region' => $region,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="data_region_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Region $region): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $this->regionService->remove($region);
            $this->addFlash('success', 'Region has removed.');
        }

        return $this->redirectToRoute('data_region_index');
    }
}
