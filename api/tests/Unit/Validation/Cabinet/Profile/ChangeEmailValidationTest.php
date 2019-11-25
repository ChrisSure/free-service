<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:20
 */

namespace App\Tests\Unit\Validation\Cabinet\Profile;

use App\Validation\Cabinet\Profile\ChangeEmailValidation;
use PHPUnit\Framework\TestCase;


class ChangeEmailValidationTest extends TestCase
{
    public function testValidate(): void
    {
        $validate = new ChangeEmailValidation();
        $data = ['email' => 'email@gmail.com'];
        $result = $validate->validate($data);

        $this->assertEquals(0, $result->count());
    }
}