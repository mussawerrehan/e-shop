<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , NULL , array('attr' => array('class' => 'form-control')))
            ->add('iconImage' , FileType::class , [
                'label' => 'Icon Image png OR jpg',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'fomr-control custom-file'
                ],
                'constraints' => [
                    new Image()
                ]
            ])
            ->add('parent_id' , NULL , array(
                'attr' => array('class' => 'form-control '),
                'label' => 'Parent Category only for Sub category'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
