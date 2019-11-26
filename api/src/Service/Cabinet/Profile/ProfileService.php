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

    public function __construct(ProfileRepository $profileRepository, UserRepository $userRepository, CityRepository $cityRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
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
     * Created user profile
     * @param array $data
     * @param int $current_user_id
     * @return void
     */
    public function createdProfile(array $data, $current_user_id): void
    {
        $user = $this->userRepository->find($data['user']);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $city = $this->cityRepository->find($data['city']);
        if (!$city)
            throw new NotFoundHttpException('City doesn\'t exist.');

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
     * @param int $current_user_id
     * @return void
     */
    public function updateProfile(array $data, $id, $current_user_id): void
    {
        $user = $this->userRepository->find($data['user']);
        if (!$user)
            throw new NotFoundHttpException('User doesn\'t exist.');

        $city = $this->cityRepository->find($data['city']);
        if (!$city)
            throw new NotFoundHttpException('City doesn\'t exist.');

        $profile = $this->profileRepository->find($id);
        if (!$profile)
            throw new NotFoundHttpException('Profile doesn\'t exist.');

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