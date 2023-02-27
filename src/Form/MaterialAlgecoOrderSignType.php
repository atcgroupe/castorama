<?php

namespace App\Form;

use App\Entity\MaterialAlgecoOrderSign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialAlgecoOrderSignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aisleNumber', NumberType::class, ['label' => 'N° d\'allée'])
            ->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add(
                'dir',
                ChoiceType::class,
                [
                    'label' => 'Direction',
                    'choices' => [
                        'GAUCHE' => MaterialAlgecoOrderSign::DIR_LEFT,
                        'DROITE' => MaterialAlgecoOrderSign::DIR_RIGHT,
                    ]
                ]
            )
            ->add(
                'save',
                SignSaveType::class,
                [
                    SignSaveType::ACTION_TYPE => $options[SignSaveType::ACTION_TYPE],
                    'mapped' => false,
                    'label' => false,
                    'row_attr' => [
                        'class' => 'mb-0'
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaterialAlgecoOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }
}
