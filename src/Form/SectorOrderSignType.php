<?php

namespace App\Form;

use App\Entity\SectorOrderSign;
use App\Entity\SectorSignItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SectorOrderSignType extends AbstractType
{
    private const SIDE_RECTO = 'recto';
    private const SIDE_VERSO = 'verso';

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add(
                'option',
                ChoiceType::class,
                [
                    'choices' => [
                        'Recto/Verso identique' => 1,
                        'Recto/Verso différents' => 2,
                    ],
                    'attr' => [
                        'class' => 'mb-4'
                    ],
                ]
            )->add(
                'item1',
                EntityType::class,
                $this->getItemSelectOption(self::SIDE_RECTO)
            )->add(
                'item2',
                EntityType::class,
                $this->getItemSelectOption(self::SIDE_VERSO)
            )->add(
                'save',
                SignSaveType::class,
                [
                    SignSaveType::ACTION_TYPE => $options[SignSaveType::ACTION_TYPE],
                    'mapped' => false,
                    'label' => false,
                    'row_attr' => [
                        'class' => 'mb-0'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SectorOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }

    /**
     * @param string $side
     *
     * @return array
     */
    private function getItemSelectOption(string $side): array
    {
        $data = [
            'class' => SectorSignItem::class,
            'choice_label' => 'label',
            'placeholder' => 'Choisissez un secteur',
            'label' => sprintf('Secteur %s', $side),
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('s')
                    ->orderBy('s.label', 'ASC');

            },
            'attr' => [
                'class' => 'sector-item-select',
                'data-route' => $this->urlGenerator->generate('order_sign_sector_color'),
                'data-face' => $side,
            ]
        ];

        if ($side === self::SIDE_RECTO) {
            $data['label_attr'] = [
                'id' => 'sector-item1-label',
            ];
        }

        return $data;
    }
}
