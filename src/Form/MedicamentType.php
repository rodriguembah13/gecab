<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('libelle',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('dosage',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('description',TextareaType::class,[
                'attr'=>['class' => 'form-control','']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
