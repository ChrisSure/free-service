<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 11:33
 */

namespace App\Controller\Cabinet\Profile;

use App\Service\Cabinet\Profile\ProfileService;
use App\Service\User\UserService;
use App\Validation\Auth\ChangePasswordValidation;
use App\Validation\Cabinet\Profile\ChangeEmailValidation;
use App\Validation\Cabinet\Profile\CreateProfileValidation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @var ProfileService
     */
    private $profileService;


    public function __construct(UserService $userService, ProfileService $profileService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
    }

    /**
     * Is filled user profile
     * @Route("/profile/{profile_id}/is-filled", name="cabinet_profile_is_filled",  methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function isFilledProfile(Request $request)
    {
        try {
            $result = $this->profileService->isFilledProfile($request->get('profile_id'));
            return new JsonResponse($result, 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Get profile by user_id
     * @Route("/profile/{id}/user", name="get_profile_by_user_id",  methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getProfileByUserId(Request $request): Response
    {
        try {
            $profile = $this->profileService->getProfileByUserId($request->get('id'));
            return new Response($profile, 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Create user profile
     * @Route("/profile", name="cabinet_create_profile",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createProfile(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new CreateProfileValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->profileService->createdProfile($data);
            return new JsonResponse("You have successfull filled your profile.", 201);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Update user profile
     * @Route("/profile/{profile_id}", name="cabinet_update_profile",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new CreateProfileValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->profileService->updateProfile($data, $request->get('profile_id'));
            return new JsonResponse("You have successfull update your profile.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }


    /**
     * Change user email
     * @Route("/profile/{id}/change-email", name="cabinet_change_email",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function changeEmail(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new ChangeEmailValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->userService->changeEmail($data, $request->get('id'));
            return new JsonResponse("You have successfull changed your email.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Change user password
     * @Route("/profile/{id}/change-password", name="cabinet_change_password",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $violations = (new ChangePasswordValidation())->validate($data);
        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        try {
            $this->userService->changePassword($data, $request->get('id'));
            return new JsonResponse("You have successfull changed your password.", 200);
        } catch (\Exception $e) {
            return new JsonResponse(["error" => $e->getMessage()], 500);
        }
    }

}