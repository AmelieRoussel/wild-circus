<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone (optionnel)',
                'required' => false,
            ])
            ->add('course', null, [
                'label' => 'Créneau de cours choisi',
                'choice_label' => 'day',
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'custom-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}