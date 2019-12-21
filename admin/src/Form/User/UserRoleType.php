<?php

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserRoleType
 * @package App\Form\Data
 */
class UserRoleType extends AbstractType
{
    /**
     * Region form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('role', ChoiceType::class, [
                'required' => true,
                'choices'  => User::rolesList(),
                'placeholder' => "Choose an role"
            ]);
    }

    /**
     * Configure
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
