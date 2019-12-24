<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 03.12.19
 * Time: 11:29
 */

namespace App\Form\Data;

use App\Entity\Data\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CityFilterType
 * @package App\Form\Data
 */
class CityFilterType extends AbstractType
{
    /**
     * User filter form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => "Enter an name"]

            ])
            ->add('region',EntityType::class, [
                'class' => Region::class,
                'required' => false,
                'choice_label' => 'name',
                'placeholder' => "Choose an region"
            ]);
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