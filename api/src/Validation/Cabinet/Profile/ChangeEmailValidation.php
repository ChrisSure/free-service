<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 01.11.19
 * Time: 10:27
 */

namespace App\Validation\Cabinet\Profile;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class ChangeEmailValidation
 * @package App\Validation\Cabinet\Profile
 */
class ChangeEmailValidation
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
                    ]
            ]
        );
        return $validator->validate($data, $constraint);
    }
}