<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , NULL , array('attr' => array('class' => 'form-control')))
            ->add('type' , NULL , array('attr' => array('class' => 'form-control')))
            ->add('ProductImage' , FileType::class , [
                'label' => 'Product Image png OR jpg \\n',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'fomr-control custom-file'
                ],
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('category' , NULL , array('attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
