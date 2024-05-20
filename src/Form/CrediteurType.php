<?php

namespace App\Form;

use App\Entity\Crediteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrediteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('voornaam')
            ->add('naam')
            ->add('tel')
            ->add('email')
            ->add('straat_nr')
            ->add('postcode')
            ->add('gemeente')
            ->add('land')
            ->add('btw_nr')
            ->add('rek_nr')
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crediteur::class,
        ]);
    }
}
