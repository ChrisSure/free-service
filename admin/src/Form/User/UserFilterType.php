<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 03.12.19
 * Time: 11:29
 */

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserFilterType
 * @package App\Form\User
 */
class UserFilterType extends AbstractType
{
    /**
     * User filter form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => "Enter an email"]

            ])
            ->add('role', ChoiceType::class, [
                'required' => false,
                'choices'  => User::rolesList(),
                'placeholder' => "Choose an role"
                ])
            ->add('status', ChoiceType::class, [
                'required' => false,
                'choices'  => User::statusList(),
                'placeholder' => "Choose an status"
            ])
        ;
    }

    /**
     * Configure
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}