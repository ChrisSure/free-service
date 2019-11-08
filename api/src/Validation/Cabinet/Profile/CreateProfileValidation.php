<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 06.11.19
 * Time: 10:25
 */

namespace App\Validation\Cabinet\Profile;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class CreateProfileValidation
 * @package App\Validation\Cabinet\Profile
 */
class CreateProfileValidation
{
    /**
     * Validor for create profile
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection(
            [
                'firstname' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 255])
                    ],
                'lastname' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 255])
                    ],
                'surname' =>
                    [
                        new Assert\Type(['type' => 'string'])
                    ],
                'about' =>
                    [
                        new Assert\Type(['type' => 'string'])
                    ],
                'birthday' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank()
                    ],
                'sex' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'numeric'])
                    ],
                'phone' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'numeric']),
                        new Assert\Regex(['pattern' => '/^[0-9]{10}$/'])
                    ],
                'city' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'numeric'])
                    ],
                'user' =>
                    [
                        new Assert\Required(),
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'numeric'])
                    ]
            ]
        );
        return $validator->validate($data, $constraint);
    }
}