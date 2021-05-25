<?php

namespace App\Form;

use App\Entity\Travel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description'
            ])
            ->add('date', DateType::class, [
                'label' => 'Date'
            ])
            ->add('duration', IntegerType::class, [
                'required' => false,
                'label' => 'Durée'
            ])
            ->add('durationType', ChoiceType::class, [
                'choices' => [
                    'Jour' => 'day',
                    'Semaine' => 'week',
                    'Mois' => 'month'
                ],
                'required' => false,
                'label' => ' '
            ])
            ->add('public', CheckboxType::class, [
                'required' => false,
                'label' => 'Public'
            ])
            ->add('slug', TextType::class, [
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'required' => false,
                'label'=> 'Pays'
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}
