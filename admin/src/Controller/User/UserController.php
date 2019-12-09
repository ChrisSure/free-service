<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 02.12.19
 * Time: 10:29
 */

namespace App\Controller\User;

use App\Entity\User\User;
use App\Form\User\UserFilterType;
use App\Form\User\UserRoleType;
use App\Form\User\UserType;
use App\Service\User\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("", name="users_index")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(UserFilterType::class);
        $form->handleRequest($request);

        $users = $paginator->paginate(
            $this->userService->getAll($request->query->get('direction'), $form->getData()),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/user/user/index.html.twig', ['users' => $users, 'form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/detail", name="users_detail")
     */
    public function detail(Request $request): Response
    {
        $user = $this->userService->get($request->get('id'));
        return $this->render('admin/user/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->createUser($form->getData());
            $this->addFlash('success', 'User has created.');
            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/user/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/change-role", name="users_edit", methods={"GET","POST"})
     */
    public function changeRole(Request $request, User $user): Response
    {
        $form = $this->createForm(UserRoleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->changeRole($user, $form->getData());
            $this->addFlash('success', 'Role has changed.');
            return $this->redirectToRoute('users_detail', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/user/chage_role.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/block", name="users_block", methods="GET")
     */
    public function blockUser(Request $request, User $user): Response
    {
            $this->userService->blockUser($user);
            $this->addFlash('success', 'User has blocked.');
            return $this->redirectToRoute('users_detail', ['id' => $user->getId()]);

    }

    /**
     * @Route("/{id}/unblock", name="users_unblock", methods="GET")
     */
    public function unblockUser(Request $request, User $user): Response
    {
        $this->userService->unblockUser($user);
        $this->addFlash('success', 'User has unblocked.');
        return $this->redirectToRoute('users_detail', ['id' => $user->getId()]);

    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->userService->remove($user);
            $this->addFlash('success', 'User has removed.');
        }

        return $this->redirectToRoute('users_index');
    }
}