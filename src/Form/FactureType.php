<?php

namespace App\Form;

use App\Entity\Facture;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'mapped' => false,
                'placeholder' => 'veuillez choisir un patient',
                'required' => true,
                'label'=>'Patient',
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 10, 'data-live-search' => true],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
