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
        $this->garantedFillUserData();

        for ($i = 5; $i < 20; $i++) {
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

    public function garantedFillUserData(ObjectManager $manager)
    {
        // Super Admin
        $user1 = new User();
        $user1->setEmail('super@gmail.com');
        $user1->setStatus('active');
        $password = $this->encoder->encodePassword($user1, '123');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_SUPER_ADMIN']);
        $user1->onPrePersist();
        $user1->onPreUpdate();
        $manager->persist($user1);
        // User
        $user2 = new User();
        $user2->setEmail('user@gmail.com');
        $user2->setStatus('active');
        $password = $this->encoder->encodePassword($user2, '123');
        $user2->setPassword($password);
        $user2->setRoles(['ROLE_USER']);
        $user2->onPrePersist();
        $user2->onPreUpdate();
        $manager->persist($user2);
        // Worker
        $user3 = new User();
        $user3->setEmail('worker@gmail.com');
        $user3->setStatus('active');
        $password = $this->encoder->encodePassword($user3, '123');
        $user3->setPassword($password);
        $user3->setRoles(['ROLE_WORKER']);
        $user3->onPrePersist();
        $user3->onPreUpdate();
        $manager->persist($user3);
        // Moderator
        $user4 = new User();
        $user4->setEmail('moderator@gmail.com');
        $user4->setStatus('active');
        $password = $this->encoder->encodePassword($user4, '123');
        $user4->setPassword($password);
        $user4->setRoles(['ROLE_MODERATOR']);
        $user4->onPrePersist();
        $user4->onPreUpdate();
        $manager->persist($user4);
    }

}
