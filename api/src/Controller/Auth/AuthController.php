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
use App\Validation\Auth\ChangePasswordValidation;
use App\Validation\Auth\UserAuthValidation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Login user
     * @Route("/login-user", name="auth_login",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->request->all();

        $violations = (new UserAuthValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $token = $this->authService->loginUser($data);
            return new JsonResponse(['token' => $token], 201);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Register user
     * @Route("/register", name="auth_register",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new UserAuthValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->registerUser($data);
            return new JsonResponse("You successfull registered, check your email for the next step.", 201);
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
    public function confirm(Request $request): JsonResponse
    {
        $data = $request->query->all();

        try {
            $this->authService->confirmUser($data);
            return new JsonResponse("Congratulation. You can sign in.", 201);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Forget user password
     * @Route("/forget", name="auth_forget",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function forget(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new ForgetValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->forgetPassword($data);
            return new JsonResponse("Check your email for the next step.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Check user token for new password
     * @Route("/check-token", name="auth_check_token",  methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function confirm_password(Request $request): JsonResponse
    {
        $data = $request->query->all();

        try {
            $this->authService->checkUserToken($data);
            return new JsonResponse("Success data.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }


    /**
     * Set new password for user
     * @Route("/new-password/{id}", name="auth_forget_password",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new_password(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new ChangePasswordValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->authService->setNewPassword($data, $request->get('id'));
            return new JsonResponse("You have set new password. You can enter in your personal cabinet.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }


}