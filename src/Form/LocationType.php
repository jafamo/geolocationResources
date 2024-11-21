<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('address', TextType::class, [
                'label' => 'Dirección',
                'attr' => ['id' => 'address', 'class' => 'address-input']
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitud',
                'required' => false,
                'disabled' => false,
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitud',
                'required' => false,
                'disabled' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
