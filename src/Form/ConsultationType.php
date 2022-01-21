<?php

namespace App\Form;

use App\Entity\Consultation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motif',TextareaType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('dianostique',TextareaType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('temperature',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('poids',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('pools',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('taille',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('creatine',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('uree',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
