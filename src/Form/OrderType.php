<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom du client',
                    'class' => 'client-name'
                ]
            ])
            ->add('quantity',IntegerType::class, [
                'label' => false,
                'attr'  => [
                    'class' => 'dish-quantity',
                    'min' => 1,
                    'max' => 50,
                    'placeholder' => 'Nombre de plats',
                ]
            ])
            ->add('dishes', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'name',
                'multiple'      => true,
                'expanded'      => false,
                'label'         => false,
                'attr' => [
                    'class' => 'dish-choice'
                ]
            ])
            ->add('comment', TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Note',
                    'class' => 'dish-comment',
                ]
            ])
            ->add('time', TextType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Heure de retrait',
                    'class' => 'order-time'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
