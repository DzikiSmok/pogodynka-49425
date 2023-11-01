<?php

namespace App\Form;

use App\Entity\Forecast;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class)
            ->add('temperature', NumberType::class)
            ->add('feels_like', NumberType::class)
            ->add('description', TextType::class)
            ->add('wind_direction', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'North-East' => 'NE',
                    'East' => 'E',
                    'South-East' => 'SE',
                    'South' => 'S',
                    'South-West' => 'SW',
                    'West' => 'W',
                    'North-West' => 'NW',
                ]
            ])
            ->add('wind_speed', NumberType::class)
            ->add('city', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
