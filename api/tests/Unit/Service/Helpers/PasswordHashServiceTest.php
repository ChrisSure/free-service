<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:00
 */

namespace App\Tests\Unit\Service\Helpers;

use App\Entity\User\User;
use App\Service\Helpers\PasswordHashService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PasswordHashServiceTest extends TestCase
{
    private $passwordService;

    protected function setUp(): void
    {
        $this->passwordService = new PasswordHashService($this->createMock(UserPasswordEncoderInterface::class));
    }

    public function testGenerateToken()
    {
        $this->assertEquals('string', gettype($this->passwordService->generateToken()));
    }

    /*public function testHashPassword()
    {
        $user = (new User())->setPassword('123')->setEmail('t@t.ua');
        $this->assertEquals('string', gettype($this->passwordService->hashPassword($user, '123')));
    }*/
}