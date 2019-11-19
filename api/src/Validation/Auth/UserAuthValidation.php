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

/**
 * Class RegisterValidation
 * @package App\Validation\Auth
 */
class UserAuthValidation
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
                'email' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Email()
                    ],
                'password' =>
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2])
                    ],

            ]
        );
        return $validator->validate($data, $constraint);
    }
}