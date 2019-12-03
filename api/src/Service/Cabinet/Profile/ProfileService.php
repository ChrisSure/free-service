<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 11:40
 */

namespace App\Service\Cabinet\Profile;
use App\Entity\User\Profile;
use App\Exceptions\NotAllowException;
use App\Repository\Data\CityRepository;
use App\Repository\User\ProfileRepository;
use App\Repository\User\UserRepository;
use App\Service\Helpers\SerializeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProfileService
 * @package App\Service\Cabinet\Profile
 */
class ProfileService
{
    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var SerializeService
     */
    private $serializeService;

    public function __construct(
        ProfileRepository $profileRepository,
        UserRepository $userRepository,
        CityRepository $cityRepository,
        SerializeService $serializeService
    )
    {
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->serializeService = $serializeService;
    }

    /**
     * Is filled user profile
     * @param $id
     * @return bool
     */
    public function isFilledProfile($id): bool
    {
        return ($this->profileRepository->findOneBy(['user' => $id])) ? true : false;
    }

    /**
     * Get profile by user id
     * @param $user_id
     * @return string
     */
    public function getProfileByUserId($user_id): string
    {
        $user = $this->userRepository->get($user_id);
        $profile = $this->profileRepository->getByUser($user);
        return $this->serializeService->serialize($profile);
    }

    /**
     * Created user profile
     * @param array $data
     * @return void
     */
    public function createdProfile(array $data): void
    {
        $user = $this->userRepository->get($data['user']);
        $city = $this->cityRepository->get($data['city']);
        if ($this->profileRepository->findOneBy(['user' => $user]))
            throw new NotAllowException('You have already filled your profile.');

        $profile = new Profile();
        $profile->setFirstname($data['firstname'])->setLastname($data['lastname'])
            ->setSurname(isset($data['surname']) ? $data['surname'] : null)->setBirthday($data['birthday'])
            ->setSex($data['sex'])->setPhone($data['phone'])
            ->setAbout(isset($data['about']) ? $data['about'] : null)
            ->onPrePersist()->onPreUpdate();

        $profile->setUser($user);
        $profile->setCity($city);

        $this->profileRepository->save($profile);
    }

    /**
     * Update user profile
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateProfile(array $data, $id): void
    {
        $user = $this->userRepository->get($data['user']);
        $city = $this->cityRepository->get($data['city']);
        $profile = $this->profileRepository->get($id);

        $profile->setFirstname($data['firstname'])->setLastname($data['lastname'])
            ->setSurname(isset($data['surname']) ? $data['surname'] : null)->setBirthday($data['birthday'])
            ->setSex($data['sex'])->setPhone($data['phone'])
            ->setAbout(isset($data['about']) ? $data['about'] : null)
            ->onPrePersist()->onPreUpdate();

        $profile->setUser($user);
        $profile->setCity($city);

        $this->profileRepository->save($profile);
    }
}