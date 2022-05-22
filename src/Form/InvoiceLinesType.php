<?php

namespace App\Form;


use App\Entity\InvoiceLines;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class InvoiceLinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'constraints' => [
                    new GreaterThan(
                        ['value' => 0.0001])
                ]
            ])
            ->add('discount', NumberType::class, [
                'constraints' => [
                    new LessThan([
                        'value' => 100]),

                    new GreaterThanOrEqual(
                        ['value' => 0])
                ]
            ])
            ->add('productId', EntityType::class, [
                'class' => Products::class,
                'choice_label' => 'description',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLines::class,
        ]);
    }
}
