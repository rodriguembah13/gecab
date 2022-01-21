<?php

namespace App\Form;

use App\Entity\ActeMedical;
use App\Entity\FactureItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount',NumberType::class,[
                'label'=>'Montant par defaut',
                'disabled'=>true,
                'attr'=>['class' => 'form-control','']
            ])
            ->add('amountFinal',NumberType::class,[
                'mapped'=>false,
                'attr'=>['class' => 'form-control','']
            ])
            ->add('quantity',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            //->add('facture')
            ->add('actemedical', EntityType::class, [
                'class' => ActeMedical::class,
                'multiple' => false,
                'placeholder' => 'Choisir un un acte medical',
                'label' => 'Acte medical',
                'required' => true,
                'attr' => ['class' => 'form-control', 'data-size' => 5, 'data-type' => '', 'data-live-search' => true],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FactureItem::class,
        ]);
    }
}
