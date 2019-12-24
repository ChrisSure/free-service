<?php

namespace App\Controller\Data;

use App\Entity\Data\City;
use App\Form\Data\CityType;
use App\Repository\Data\CityRepository;
use App\Service\Data\CityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/data/city")
 */
class CityController extends AbstractController
{
    private $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * @Route("/", name="data_city_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/data/city/index.html.twig', [
            'cities' => $this->cityService->getAll(),
        ]);
    }

    /**
     * @Route("/new", name="data_city_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cityService->save($city);
            $this->addFlash('success', 'City has created.');
            return $this->redirectToRoute('data_city_index');
        }

        return $this->render('admin/data/city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="data_city_show", methods={"GET"})
     */
    public function show($id): Response
    {
        return $this->render('admin/data/city/show.html.twig', [
            'city' => $this->cityService->get($id),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="data_city_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->cityService->save($city);
            $this->addFlash('success', 'City has updated.');
            return $this->redirectToRoute('data_city_index');
        }

        return $this->render('admin/data/city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="data_city_delete", methods={"DELETE"})
     */
    public function delete(Request $request, City $city): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $this->cityService->remove($city);
            $this->addFlash('success', 'City has removed.');
        }

        return $this->redirectToRoute('data_city_index');
    }
}
