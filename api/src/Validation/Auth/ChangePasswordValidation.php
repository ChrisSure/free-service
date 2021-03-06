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
 * Class ChangePasswordValidation
 * @package App\Validation\Auth
 */
class ChangePasswordValidation
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
                'password' =>
                    [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2]),
                    ]
            ]
        );
        return $validator->validate($data, $constraint);
    }
}