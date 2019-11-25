<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:19
 */

namespace App\Tests\Unit\Validation\Auth;

use App\Validation\Auth\UserAuthValidation;
use PHPUnit\Framework\TestCase;


class UserAuthValidationTest extends TestCase
{
    public function testValidate(): void
    {
        $validate = new UserAuthValidation();
        $data = ['email' => 'email@gmail.com', 'password' => '123'];
        $result = $validate->validate($data);

        $this->assertEquals(0, $result->count());
    }
}