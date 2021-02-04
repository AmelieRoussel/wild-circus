<?php

namespace App\Form;

use App\Entity\Member;
use App\Repository\CourseRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;

class EnrollmentType extends AbstractType
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
                'choice_label' => 'id',
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => 'custom-select'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je m\'engage à régler la cotisation lors de la première séance, au risque de voir mon inscription annulée.'
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
