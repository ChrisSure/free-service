<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 12:40
 */

namespace App\Controller\Auth;

use App\Service\Auth\AuthService;
use App\Service\User\UserService;
use App\Validation\Auth\ForgetValidation;
use App\Validation\Auth\NewPasswordValidation;
use App\Validation\Auth\RegisterValidation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    private $authService;
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Register user (worker | user)
     * @Route("/register", name="auth_register",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $violations = (new RegisterValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->registerUser($data);
            return new JsonResponse("You successfull registered, check your email for the next step.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Confirm user email
     * @Route("/confirm", name="auth_confirm",  methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function confirm(Request $request)
    {
        $user = $this->userService->getUserByTokenId($request->get('id'), $request->get('token'));
        if (!$user) {
            return new JsonResponse("You have missed data.", 401);
        } else {
            $this->userService->changeUserActiveStatus($request->get('id'));
            return new JsonResponse("Congratulation. You can log in with new password.");
        }
    }

    /**
     * Forget user password
     * @Route("/forget", name="auth_forget",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function forget(Request $request)
    {
        $data = [
            'email' => $request->get('email'),
        ];

        $violations = (new ForgetValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->forgetPassword($data);
            return new JsonResponse("Check your email for the next step.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Confirm user token for new password
     * @Route("/confirm-password", name="auth_confirm",  methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function confirm_password(Request $request)
    {
        $user = $this->userService->getUserByTokenId($request->get('id'), $request->get('token'));
        if (!$user) {
            return new JsonResponse("You have missed data.", 401);
        }
        return new JsonResponse("Success.");
    }


    /**
     * Set new password for user
     * @Route("/new-password", name="auth_forget_password",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new_password(Request $request)
    {
        $data = [
            'id'   =>  $request->get('id'),
            'password' => $request->get('password'),
            'password_compare' => $request->get('password_compare'),
        ];

        $violations = (new NewPasswordValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->setNewPassword($data);
            return new JsonResponse("You have set new password. You can enter in your personal cabinet.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

    }


}