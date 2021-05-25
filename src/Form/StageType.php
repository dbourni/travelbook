<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('date', DateType::class, [
                'required' => false,
                'label' => 'Date'
            ])
            ->add('area', TextType::class, [
                'required' => false,
                'label' => 'Aire de service'
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
                'label' => 'Description'
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'label' => 'Ville'
            ])
            ->add('persons', TextType::class, [
                'required' => false,
                'label' => 'Personnes'
            ])
            ->add('orderintravel', IntegerType::class, [
                'required' => false,
                'label' => 'Ordre dans la page'
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
