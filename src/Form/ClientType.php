<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\ZoneGeographique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('societe')
            ->add('tvaIntracommunautaire', null, array(
                'label' => 'TVA Intracommunautaire'
            ))
            ->add('adresse')
            ->add('zone', EntityType::class, array(
                'class'=> ZoneGeographique::class,
                'choice_label'=>'zone',))
            ->add('telephone')
            ->add('mail');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
