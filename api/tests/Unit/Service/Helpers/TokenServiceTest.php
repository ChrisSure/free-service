<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.12.19
 * Time: 10:57
 */

namespace App\Tests\Unit\Service\Helpers;

use App\Service\Helpers\TokenService;
use PHPUnit\Framework\TestCase;


class TokenServiceTest extends TestCase
{
    public function testGenerateToken()
    {
        $tokenService = new TokenService();
        $this->assertEquals('object', gettype($tokenService->generateToken()));
    }
}