<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 11:33
 */

namespace App\Controller\Cabinet\Profile;

use App\Service\User\UserService;
use App\Validation\Auth\ChangePasswordValidation;
use App\Validation\Cabinet\Profile\ChangeEmailValidation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cabinet")
 */
class ProfileController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Change user email
     * @Route("/change-email", name="cabinet_chanhe_email",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function change_email(Request $request): JsonResponse
    {
        $data = [
            'id' => $request->get('id'),
            'email' => $request->get('email'),
        ];

        $violations = (new ChangeEmailValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->userService->changeEmail($data, $this->getUser()->getId());
            return new JsonResponse("You have successfull changed your email.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Change user password
     * @Route("/change-password", name="cabinet_chanhe_password",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function change_password(Request $request): JsonResponse
    {
        $data = [
            'id' => $request->get('id'),
            'password' => $request->get('password'),
            'password_compare' => $request->get('password_compare')
        ];

        $violations = (new ChangePasswordValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->userService->changePassword($data, $this->getUser()->getId());
            return new JsonResponse("You have successfull changed your password.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

}