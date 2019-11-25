<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:17
 */

namespace App\Tests\Unit\Validation\Auth;

use App\Validation\Auth\ForgetValidation;
use PHPUnit\Framework\TestCase;


class ForgetValidationTest extends TestCase
{
    public function testValidate(): void
    {
        $validate = new ForgetValidation();
        $data = ['email' => 'email@gmail.com'];
        $result = $validate->validate($data);

        $this->assertEquals(0, $result->count());
    }
}