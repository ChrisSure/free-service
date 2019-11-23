<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:12
 */

namespace App\Tests\Unit\Validation\Auth;

use App\Validation\Auth\ChangePasswordValidation;
use PHPUnit\Framework\TestCase;


class ChangePasswordValidationTest extends TestCase
{
    public function testValidate(): void
    {
        $validate = new ChangePasswordValidation();
        $data = ['password' => '123'];
        $result = $validate->validate($data);

        $this->assertEquals(0, $result->count());
    }
}