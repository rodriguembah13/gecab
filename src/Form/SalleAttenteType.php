<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\SalleAttente;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleAttenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('createdAt')
           /*  ->add('heureArrive')
         ->add('heureFin',TimeType::class,[

           ])*/
            ->add('motif',TextareaType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'multiple' => false,
                'placeholder' => 'veuillez choisir un patient',
                'required' => true,
                'label'=>'Patient',
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 10, 'data-live-search' => true],
            ])
            ->add('medecin', EntityType::class, [
                'class' => User::class,
                'multiple' => false,
                'mapped'=>false,
                'placeholder' => 'veuillez choisir un medecin',
                'required' => true,
                'label'=>'Medecin',
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 10, 'data-live-search' => true],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalleAttente::class,
        ]);
    }
}
