<?php

namespace App\Form;

use App\Entity\Music;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('duration', TimeType::class, [
                "with_seconds" => true,
                'attr' => ['class' => 'flex flex-wrap'],
                'row_attr' => ['class' => 'flex'],
                'widget' => 'single_text',
                'data' => new DateTime("00:00:00"),

            ])
            ->add('featuring')
        ->add('album');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Music::class,
        ]);
    }
}