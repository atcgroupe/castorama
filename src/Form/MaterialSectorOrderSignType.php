<?php

namespace App\Form;

use App\Entity\MaterialSectorOrderSign;
use App\Entity\MaterialSectorSignItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialSectorOrderSignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aisleNumber', TextType::class, ['label' => 'Numéro d\'allée', 'attr' => ['autofocus' => true]])
            ->add(
                'alignment',
                ChoiceType::class,
                $this->getAlignmentOptions($options[SignSaveType::ACTION_TYPE]),
            )
            ->add('quantity', NumberType::class, ['label' => 'Quantité'])
            ->add('sector', EntityType::class,
              [
                  'label' => 'Secteur',
                  'class' => MaterialSectorSignItem::class,
                  'choice_label' => 'label',
                  'query_builder' => function (EntityRepository $er) {
                      return $er->createQueryBuilder('i')
                          ->orderBy('i.label', 'ASC');
                  },
                  'placeholder' => 'Choisissez un secteur',
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
            'data_class' => MaterialSectorOrderSign::class,
            SignSaveType::ACTION_TYPE => SignSaveType::CREATE,
        ]);
    }

    /**
     * @param string $actionType SignSaveType::ACTION_TYPE
     * @return array
     */
    private function getAlignmentOptions(string $actionType): array
    {
        $choices = [
            'GAUCHE' => MaterialSectorOrderSign::ALIGN_LEFT,
            'DROITE' => MaterialSectorOrderSign::ALIGN_RIGHT,
        ];

        if ($actionType === SignSaveType::CREATE) {
            $choices['GAUCHE + DROITE'] = MaterialSectorOrderSign::ALIGN_ALL;
            $help = '
                Si vous selectionnez l\'option "GAUCHE + DROITE", lors de l\'enregistrement, deux panneaux seront créés:
                Un panneau gauche + un panneau droite.
                Ces panneaux resteront modifiables et supprimables séparément depuis la liste des panneaux
                dans le détail de la commande.
            ';
        }

        $options = [
            'label' => 'Alignement du texte',
            'choices' => $choices,
        ];

        if (isset($help)) {
            $options['help'] = $help;
        }

        return $options;
    }
}
