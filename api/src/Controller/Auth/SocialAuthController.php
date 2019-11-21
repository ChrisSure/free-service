<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 21.11.19
 * Time: 12:51
 */

namespace App\Controller\Auth;

use App\Service\Auth\SocialAuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/auth")
 */
class SocialAuthController extends AbstractController
{
    /**
     * @var SocialAuthService
     */
    private $socialAuthService;


    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }


    /**
     * Login socialuser
     * @Route("/login-social-user", name="auth_social_login",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function loginSocial(Request $request)
    {
        $data = $request->request->all();

        try {
            $token = $this->socialAuthService->loginSocialUser($data);
            return new JsonResponse(['token' => $token], 201);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }
}