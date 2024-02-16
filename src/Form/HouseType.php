<?php

namespace App\Form;

use App\Entity\House;
use App\ModelTransformer\PriceTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HouseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFiles', FileType::class, [
                'required' => false,
                'multiple' => true,
                'label' => 'télécharger des photos'
            ])
            ->add('name')
            ->add('rooms')
            ->add('area')
            ->add('price')
            ->add('options')
        ;

        $builder->get('price')->addModelTransformer(new PriceTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => House::class,
        ]);
    }
}
