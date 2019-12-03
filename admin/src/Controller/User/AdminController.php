<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 02.12.19
 * Time: 10:29
 */

namespace App\Controller\User;

use App\Form\User\AdminFilterType;
use App\Service\User\AdminService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    private $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @Route("/admins", name="admins")
     */
    public function admins(Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(AdminFilterType::class);
        $form->handleRequest($request);

        $admins = $paginator->paginate(
            $this->adminService->getAll($request->query->get('direction'), $form->getData()),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/user/admin/index.html.twig', ['admins' => $admins, 'form' => $form->createView()]);
    }

    /**
     * @Route("/admins/{id}", name="admins_detail")
     */
    public function detail(Request $request): Response
    {
        $admin = $this->adminService->get($request->get('id'));
        return $this->render('admin/user/admin/show.html.twig', ['admin' => $admin]);
    }
}