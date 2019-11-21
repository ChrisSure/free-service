<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 21.11.19
 * Time: 12:53
 */

namespace App\Service\Auth;

use App\Entity\User\SocialUser;
use App\Entity\User\User;
use App\Repository\User\SocialUserRepository;
use App\Repository\User\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class SocialAuthService
{
    /**
     * @var JwtService
     */
    private $jwtService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SocialUserRepository
     */
    private $socialRepository;

    public function __construct(JwtService $jwtService, UserRepository $userRepository, SocialUserRepository $socialRepository)
    {
        $this->jwtService = $jwtService;
        $this->userRepository = $userRepository;
        $this->socialRepository = $socialRepository;
    }

    /**
     * Login social user
     * @param array $data
     * @return string
     */
    public function loginSocialUser(array $data): string
    {
        if (!in_array($data['provider'],SocialUser::$listProviders))
            throw new NotFoundHttpException('Provider' . $data['provider'] . ' doesn\'t exist.');

        $user = $this->userRepository->findOneBy(['email' => $data['email']]);
        if (!$user) {
            $user = new User();
            $user->setEmail($data['email'])->setRoles(['ROLE_USER'])->setStatus('active')
                ->onPrePersist()->onPreUpdate();
            $this->userRepository->save($user);
        }
        if (!in_array($data['provider'], $this->getArrayProviders($user))) {
            $socialUser = new SocialUser();
            $socialUser->setUser($user)->setSocialId($data['social_id'])->setProvider($data['provider'])
                ->setSocialName($data['social_name'])->setSocialImage($data['social_image'])
                ->setSocialToken($data['social_token']);
            $this->socialRepository->save($socialUser);
        }

        return $this->jwtService->createToken($user);
    }

    /**
     * Return array social providers
     * @param User $user
     * @return array
     */
    private function getArrayProviders(User $user): array
    {
        $array_providers = [];
        foreach ($user->getSocial() as $value) {
            $array_providers[] = $value->getProvider();
        }
        return $array_providers;
    }

}