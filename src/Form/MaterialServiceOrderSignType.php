<?php

namespace App\Form;

use App\Entity\MaterialServiceOrderSign;
use App\Entity\MaterialServiceSignItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialServiceOrderSignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'item1',
                EntityType::class,
                [
                    'label' => 'Premier service',
                    'class' => MaterialServiceSignItem::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->andWhere('i.color = :color')
                            ->setParameter('color', MaterialServiceSignItem::COLOR_YELLOW);
                    },
                    'choice_label' => 'label'
                ]
            )->add(
                'item2',
                EntityType::class,
                [
                    'label' => 'Premier service',
                    'class' => MaterialServiceSignItem::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->andWhere('i.color = :color')
                            ->setParameter('color', MaterialServiceSignItem::COLOR_BLUE);
                    },
                    'choice_label' => 'label'
                ]
            )->add('quantity', NumberType::class, ['label' => 'Quantité'])
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
            'data_class' => MaterialServiceOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }
}
