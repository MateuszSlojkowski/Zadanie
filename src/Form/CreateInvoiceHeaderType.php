<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\InvoiceHeader;
use App\Entity\PaymentCodes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateInvoiceHeaderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nr')
            ->add('sellingDate')
            ->add('paymentCode', EntityType::class, [
                'class' => PaymentCodes::class,
                'choice_label' => 'description',
            ])
            ->add('sellTo', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'name',
                'choice_filter' => ChoiceList::filter(
                    $this,
                    function ($clients) {
                        if ($clients) {
                            return $clients->getType() == "" || $clients->getType() == "company client";
                        } else
                            return 0;
                    },
                    'clients_sellTo'
                ),
            ])
            ->add('SellFrom', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'name',
                'choice_filter' => ChoiceList::filter(
                    $this,
                    function ($clients) {
                        if ($clients) {
                            return $clients->getType() == "" || $clients->getType() == "me";
                        } else
                            return 0;
                    },
                    'clients_SellFrom'
                ),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceHeader::class,
        ]);
    }
}
