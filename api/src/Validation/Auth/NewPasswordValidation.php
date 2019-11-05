<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.11.19
 * Time: 10:27
 */

namespace App\Validation\Auth;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;


class NewPasswordValidation
{
    /**
     * Validor for registartion
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection(
            [
                'id' =>
                    [
                        new Assert\NotBlank()
                    ],
                'password' =>
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2]),
                        new Assert\EqualTo(['value' => $data['password_compare'], 'message' => 'Passwords don\'t compare'])
                    ],
                'password_compare' =>
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2])
                    ]
            ]
        );
        return $validator->validate($data, $constraint);
    }
}