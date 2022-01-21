<?php

namespace App\Form;

use App\Entity\Antecedant;
use App\Entity\AntecedantPatient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AntecedantPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('antecedant',EntityType::class,[
                'class'=>Antecedant::class,
                'mapped'=>false,
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 5, 'data-type' => '', 'data-live-search' => true],
            ])
           // ->add('groupe')
            ->add('traitement',TextType::class,[
               'attr'=>['class' => 'form-control','']
           ])
            ->add('dateBegin',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'property_path' => 'dateBegin',
                'attr'=>['class' => 'form-control daterangepicker2','']
            ])
            ->add('dateEnd',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'property_path' => 'dateEnd',
                'attr'=>['class' => 'form-control daterangepicker2','']
            ])
            //->add('patient')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AntecedantPatient::class,
        ]);
    }
}
