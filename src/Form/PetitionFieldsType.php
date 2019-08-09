<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PetitionFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', CheckboxType::class, ['required' => false])
            ->add('petitionID', CheckboxType::class, ['required' => false])
            ->add('link', CheckboxType::class, ['required' => false])
            ->add('signature_count', CheckboxType::class, ['required' => false])
            ->add('summary', CheckboxType::class, ['required' => false])
            ->add('description', CheckboxType::class, ['required' => false])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
