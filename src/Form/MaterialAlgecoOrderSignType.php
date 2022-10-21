<?php

namespace App\Form;

use App\Entity\MaterialAlgecoOrderSign;
use App\Entity\MaterialAlgecoSignItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('item1', EntityType::class, $this->getItemOption(1))
            ->add('item2', EntityType::class, $this->getItemOption(2))
            ->add('item3', EntityType::class, $this->getItemOption(3))
            ->add('item4', EntityType::class, $this->getItemOption(4))
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

    /**
     * @param int $itemNumber
     * @return array
     */
    private function getItemOption(int $itemNumber): array
    {
        $options = [
            'label' => sprintf('Famille n°%s', $itemNumber),
            'class' => MaterialAlgecoSignItem::class,
            'choice_label' => 'label',
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('m')
                    ->orderBy('m.label', 'ASC');
            },
            'attr' => [
                'class' => 'sign-item-select',
            ]
        ];

        if ($itemNumber > 1) {
            $options['required'] = false;
        }

        return $options;
    }
}
