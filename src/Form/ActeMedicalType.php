<?php

namespace App\Form;

use App\Entity\ActeMedical;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeMedicalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'form-control', '']
            ])
            ->add('code', TextType::class, [
                'attr' => ['class' => 'form-control', '']
            ])
            ->add('prix', NumberType::class, [
                'attr' => ['class' => 'form-control', '']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActeMedical::class,
        ]);
    }
}
