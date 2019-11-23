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
        $this->garantedFillUserData($manager);

        for ($i = 4; $i < 20; $i++) {
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
            $profile->setPhone('0979873654');
            $profile->setAbout('about' .$i);
            $profile->setBirthday('2012-07-31');
            $profile->onPrePersist();
            $profile->onPreUpdate();
            // Create Profile

            // Create Users
            $user = new User();
            $user->setEmail('user'.$i. '@gmail.com');
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $statusArray = [User::$STATUS_ACTIVE, User::$STATUS_NEW, User::$STATUS_BLOCKED];
            $user->setStatus($statusArray[array_rand($statusArray)]);
            $rolesArray = [User::$ROLE_USER, User::$ROLE_MODERATOR, User::$ROLE_ADMIN];
            $user->setRoles([$rolesArray[array_rand($rolesArray)]]);
            $user->onPrePersist();
            $user->onPreUpdate();
            // Create Users

            // Persist objects and save
            $profile->setUser($user);
            $profile->setCity($city);

            $manager->persist($profile);
            $manager->persist($user);
            // Persist objects and save
        }
        // Create Users All

        $manager->flush();
    }

    public function garantedFillUserData(ObjectManager $manager)
    {
        // Super Admin
        $user1 = new User();
        $user1->setEmail('super@gmail.com');
        $user1->setStatus(User::$STATUS_ACTIVE);
        $password = $this->encoder->encodePassword($user1, '123');
        $user1->setPassword($password);
        $user1->setRoles([User::$ROLE_SUPER_ADMIN]);
        $user1->onPrePersist();
        $user1->onPreUpdate();
        $manager->persist($user1);
        // User
        $user2 = new User();
        $user2->setEmail('user@gmail.com');
        $user2->setStatus(User::$STATUS_ACTIVE);
        $password = $this->encoder->encodePassword($user2, '123');
        $user2->setPassword($password);
        $user2->setRoles([User::$ROLE_USER]);
        $user2->onPrePersist();
        $user2->onPreUpdate();
        $manager->persist($user2);
        // Moderator
        $user3 = new User();
        $user3->setEmail('moderator@gmail.com');
        $user3->setStatus(User::$STATUS_ACTIVE);
        $password = $this->encoder->encodePassword($user3, '123');
        $user3->setPassword($password);
        $user3->setRoles([User::$ROLE_MODERATOR]);
        $user3->onPrePersist();
        $user3->onPreUpdate();
        $manager->persist($user3);

        $manager->flush();
    }

}
