<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Rendezvous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateRdv',DateTimeType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd hh:mm',
                'attr'=>['class' => 'form-control daterangepickertime2','']
            ])
            ->add('description',TextareaType::class,[
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
