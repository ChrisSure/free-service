<?php

namespace App\DataFixtures;

use App\Entity\Data\City;
use App\Entity\Data\Region;
use App\Entity\User\Profile;
use App\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        // Create Users All
        for ($i = 1; $i < 20; $i++) {
            // Create Users
            $user = new User();
            $user->setEmail('user'.$i. '@gmail.com');
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $statusArray = ['new', 'active', 'blocked'];
            $user->setStatus($statusArray[array_rand($statusArray)]);
            $rolesArray = ['ROLE_USER', 'ROLE_WORKER', 'ROLE_MODERATOR', 'ROLE_ADMIN'];
            $user->setRoles([$rolesArray[array_rand($rolesArray)]]);
            $user->onPrePersist();
            $user->onPreUpdate();
            // Create Users

            //Create Data
            $region = new Region();
            $region->setName('Region ' .$i);
            $manager->persist($region);

            $city = new City();
            $city->setName('City ' . $i);
            $city->setRegion($region);
            $manager->persist($city);
            //Create Data

            // Create Profile
            $profile = new Profile();
            $profile->setFirstname('firstname' .$i);
            $profile->setLastname('lastname' .$i);
            $profile->setSurname('surname' .$i);
            $profile->setSex(mt_rand(0, 1));
            $profile->setAbout('about' .$i);
            $profile->setUser($user);
            $profile->setBirthday(new \DateTime('2000-01-01'));
            $profile->onPrePersist();
            $profile->onPreUpdate();
            $profile->setCity($city);
            $manager->persist($profile);
            // Create Profile

            $manager->persist($user);
        }
        // Create Users All

        $manager->flush();
    }

}
