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
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function register(Request $request, ValidatorInterface $validator)
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
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function confirm(Request $request, ValidatorInterface $validator)
    {
        $user = $this->userService->getUserByTokenId($request->get('id'), $request->get('token'));
        if (!$user) {
            return new JsonResponse("You have missed token.");
        } else {
            $this->userService->changeUserActiveStatus($request->get('id'));
            return new JsonResponse("Congratulation. You can log in.");
        }
    }

}