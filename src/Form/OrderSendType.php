<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderSendType extends OrderInfoType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customerReference', TextType::class, ['label' => 'Numéro DataMerch.'])
            ->add(
                'comment',
                TextareaType::class,
                [
                    'label' => 'Commentaire à l\'attention de l\'imprimeur',
                    'attr' => [
                        'rows' => 6
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'validation_groups' => ['order_send'],
        ]);
    }
}
