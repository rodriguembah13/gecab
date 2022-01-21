<?php

namespace App\Form;

use App\Entity\Clinique;
use App\Entity\FamillePatient;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    private $patientRepository;

    /**
     * @param $patientRepository
     */
    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,[
                'data'=>$this->patientRepository->getAfterNumber(),
                'attr'=>['class' => 'form-control','']
            ])
            ->add('nomComplet',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('civilite',ChoiceType::class,[
                'choices'=>['Mr' => 'mr', 'Mme' => 'mme', 'Mlle' => 'mlle'],
                'expanded'=>false,
                'attr'=>['class' => 'form-control','']
            ])
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'property_path' => 'dateNaissance',
                'attr'=>['class' => 'form-control daterangepicker2','']
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => ['Masculin' => 'm', 'Feminin' => 'f'],
                'help' => 'Choisir le sexe',
                'required' => false,
                'expanded'=>false,
                'attr'=>['class' => 'form-control']
            ])
            ->add('situationfamiliale',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('adresse',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('telephone',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('profession',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('groupsanguin',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('taille',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('poids',NumberType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('nomgarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('relactiongarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('regiongarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('villegarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('paysgarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('telephonegarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('adressegarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('pingarde',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('ville',TextType::class,[
                'attr'=>['class' => 'form-control','']
            ])
            ->add('numero',TextType::class,[
                'mapped'=>false,
                'disabled'=>true,
                'data'=>$this->patientRepository->getAfterNumber(),
                'attr'=>['class' => 'form-control','']
            ])
            ->add('photo',FileType::class,[
                'mapped'=>false,
                'attr'=>['class' => 'form-control','']
            ])
            ->add('famille',EntityType::class,[
                'class'=>FamillePatient::class,
                'mapped'=>false,
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 5, 'data-type' => '', 'data-live-search' => true],
            ])
            ->add('clinique',EntityType::class,[
                'class'=>Clinique::class,
                'mapped'=>false,
                'attr' => ['class' => 'selectpicker form-control', 'data-size' => 5, 'data-type' => '', 'data-live-search' => true],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
