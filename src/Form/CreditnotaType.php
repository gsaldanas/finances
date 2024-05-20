<?php

namespace App\Form;

use App\Entity\Crediteur;
use App\Entity\Creditnota;
use App\Entity\Debiteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditnotaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referentie')
            ->add('datum', null, [
                'widget' => 'single_text',
            ])
            ->add('bedrag')
            ->add('crediteur', EntityType::class, [
                'class' => Crediteur::class,
                'choice_label' => function (Crediteur $crediteur) {
                    return $crediteur->getId() . ' - ' . $crediteur->getVoornaam() . ' ' . $crediteur->getNaam();
                }
            ])
            ->add('debiteur', EntityType::class, [
                'class' => Debiteur::class,
                'choice_label' => function (Debiteur $debiteur) {
                    return $debiteur->getId() . ' - ' . $debiteur->getVoornaam() . ' ' . $debiteur->getNaam();
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Creditnota::class,
        ]);
    }
}
