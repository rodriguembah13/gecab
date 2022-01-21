<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Prescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrecriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dosage',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('quantite',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
           // ->add('format')
           // ->add('nombre')
            //->add('ordonance')
            ->add('medicament', EntityType::class, [
                'class' => Medicament::class,
                'multiple' => false,
                'placeholder' => 'Choisir un medicament',
                'label' => 'Medicament',
                'required' => true,
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 5, 'data-type' => '', 'data-live-search' => true],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
