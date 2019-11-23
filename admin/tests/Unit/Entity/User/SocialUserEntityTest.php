<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 11:58
 */

namespace App\Tests\Unit\Entity\User;

use App\Entity\User\SocialUser;
use App\Entity\User\User;
use PHPUnit\Framework\TestCase;


class SocialUserEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $socialUser = new SocialUser();
        $socialUser->setSocialId($socialId = 123);
        $socialUser->setProvider($provider = 'facebook');
        $socialUser->setSocialName($socialName = "name");
        $socialUser->setSocialImage($socialImage = "image");
        $socialUser->setSocialToken($socialToken = "token");
        $socialUser->setUser($user = $this->createMock(User::class));

        $this->assertEquals($socialId, $socialUser->getSocialId());
        $this->assertEquals($provider, $socialUser->getProvider());
        $this->assertEquals($socialName, $socialUser->getSocialName());
        $this->assertEquals($socialImage, $socialUser->getSocialImage());
        $this->assertEquals($socialToken, $socialUser->getSocialToken());

        $this->assertEquals(gettype($user), gettype($socialUser->getUser()));
    }
}