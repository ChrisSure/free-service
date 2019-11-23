<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 11:47
 */

namespace App\Tests\Unit\Entity\User;

use App\Entity\Data\City;
use App\Entity\User\Profile;
use App\Entity\User\User;
use PHPUnit\Framework\TestCase;


class ProfileEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $profile = new Profile();
        $profile->setFirstname($firstname = "Firstname");
        $profile->setLastname($lastname = "Lastname");
        $profile->setSurname($surname = "Surname");
        $profile->setAbout($about = "About");
        $profile->setPhone($phone = "0987653467");
        $profile->setSex($sex = 1);
        $profile->setBirthday($birthday = '2000-02-19');
        $profile->setUser($user = $this->createMock(User::class));
        $profile->setCity($city = $this->createMock(City::class));

        $this->assertEquals($firstname, $profile->getFirstname());
        $this->assertEquals($lastname, $profile->getLastname());
        $this->assertEquals($surname, $profile->getSurname());
        $this->assertEquals($about, $profile->getAbout());
        $this->assertEquals($phone, $profile->getPhone());
        $this->assertEquals($sex, $profile->getSex());
        $this->assertEquals(date_create($birthday), $profile->getBirthday());
        $this->assertEquals(gettype($user), gettype($profile->getUser()));
        $this->assertEquals(gettype($city), gettype($profile->getCity()));


    }
}