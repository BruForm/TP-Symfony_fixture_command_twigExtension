<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST') // POST par defaut donc ligne inutile en POST
            ->add('name')
            ->add('duration')
            ->add('price')
            ->add('releaseddAt')
            ->add('note')
//            ->add('imagePath')
            ->add('imageFile', FileType::class, [
                'mapped' => false, // indique que ce champ n'est pas lié à l'entité
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
