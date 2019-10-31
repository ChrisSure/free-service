<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 31.10.19
 * Time: 12:40
 */

namespace App\Controller\Auth;

use App\Entity\User\User;
use App\Service\Auth\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/auth")
 */
class AuthController extends AbstractController
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/register", name="auth_register",  methods={"POST"})
     * @param Request $request
     * @param UserInterface $userManager
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $password = $encoder->encodePassword($user, $request->get('password'));
        $token = $this->service->generateToken();

        $user
            ->setEmail($request->get('email'))
            ->setPassword($password)
            ->setRoles(($request->get('role') == 'worker') ? ['ROLE_WORKER'] : ['ROLE_USER'])
            ->setStatus('new')
            ->setToken($token)
            ->onPrePersist()->onPreUpdate();

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse(["error" => (string)$errors], 500);
        }

        try {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->service->sendCheckRegistration($user, $token);
            return new JsonResponse("You successfull registered, check your email for the next step.");
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }

    }
}