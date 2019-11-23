<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 12:03
 */

namespace App\Tests\Unit\Entity\User;

use App\Entity\User\Profile;
use App\Entity\User\SocialUser;
use App\Entity\User\User;
use PHPUnit\Framework\TestCase;


class UserEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $user = new User();
        $user->setEmail($email = "email@gmail.com");
        $user->setPassword($password = "123");
        $user->setRoles($role = ["ROLE_USER"]);
        $user->setStatus($status = "active");
        $user->setToken($token = "token");
        $user->setProfile($profile = $this->createMock(Profile::class));
        $user->setSocial($socialUser = $this->createMock(SocialUser::class));

        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($role, $user->getRoles());
        $this->assertEquals($status, $user->getStatus());
        $this->assertEquals($token, $user->getToken());

        $this->assertEquals(gettype($profile), gettype($user->getProfile()));
        $this->assertEquals(gettype($socialUser), gettype($user->getSocial()));
    }
}