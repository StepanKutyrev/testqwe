<?php

namespace App\Form;

use App\Entity\Likes;
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
                    'placeholder' => 'Enter description',
                    'class'=>"form-control"
                ]
            ])
            ->add('image_name' , FileType::class , [
                'mapped'=> false ,
                'required' => true,
                'attr'=>[
                   'class'=> 'form-control',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                    ])
                ],
            ])
            ->add('date' , TextareaType::class,[
                 'attr'=>[
                     'class'=> 'form-control',
                        'placeholder' => 'enter the name of the day'
                 ],
            ])
            ->add('trueDate' , DateType::class , [
                'widget' => 'choice',
            ])
            ->add('save' , SubmitType::class,[
                'attr'=>[
                    'class'=> 'btn btn-success',
                    'style'=>'margin-top:20px ; width:70px'
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
