<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 23.11.19
 * Time: 13:21
 */

namespace App\Tests\Unit\Validation\Cabinet\Profile;

use App\Validation\Cabinet\Profile\CreateProfileValidation;
use PHPUnit\Framework\TestCase;


class CreateProfileValidationTest extends TestCase
{
    public function testValidate(): void
    {
        $validate = new CreateProfileValidation();
        $data = [
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'surname' => 'surname',
            'about' => 'about',
            'birthday' => '2000-12-09',
            'sex' => 1,
            'phone' => '0980983774',
            'city' => 1,
            'user' => 1
        ];
        $result = $validate->validate($data);

        $this->assertEquals(0, $result->count());
    }
}