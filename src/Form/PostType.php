<?php

namespace App\Form;

use App\Entity\Posts;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description' , TextareaType::class,[
                'attr'=>[
                    'placeholder' => 'enter description'
                ]
            ])
            ->add('image_name' , FileType::class , [
                'mapped'=> false ,
                'label' =>"please upload the file",
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ->add('date' , TextareaType::class,[
                'attr'=>[
                    'placeholder' => 'enter the name of the day'
                ]
            ])
            ->add('trueDate' , DateType::class , [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
            ])
            ->add('save' , SubmitType::class,[
                'attr'=>[
                    'class'=> 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
