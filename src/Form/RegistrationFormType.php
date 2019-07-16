<?php

namespace App\Form;

use App\Entity\County;
use App\Entity\Trade;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dateMin = new \DateTime('2008-01-01');
        $dateMin = $dateMin->format('Y-m-d');
        $dateMax = new \DateTime();
        $dateMax = $dateMax->format('Y-m-d');

        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'label_attr' => ['class' => 'col-sm-12'],
                'attr' => ['placeholder' => 'Thierry'],
                'invalid_message' => 'Saisis ton prénom',
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-sm-12'],
                'attr' => ['placeholder' => 'Gomedj'],
                'invalid_message' => 'Saisis ton nom',
            ])
            ->add('enteredAt', DateType::class, [
                'label' => 'Année d\'entrée au Royaume :',
                'required' => true,
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'text-left',
                    'min' => $dateMin,
                    'max' => $dateMax,
                ],
                'label_attr' => ['class' => 'col-sm-12'],
                'constraints' => new NotBlank(['message' => 'Champ obligatoire']),
                'widget' => 'single_text',
                'format' => 'yyyy',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('knightedAt', DateType::class, [
                'label' => 'Année d\'adoubement :',
                'required' => false,
                'data' => null,
                'attr' => [
                    'class' => 'text-left',
                    'min' => $dateMin,
                    'max' => $dateMax,
                ],
                'label_attr' => ['class' => 'col-sm-12'],
                'widget' => 'single_text',
                'format' => 'yyyy',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-sm-12'],
                'attr' => ['placeholder' => '06123456789'],
            ])
            ->add('trades', EntityType::class, [
                'required' => true,
                'class' => Trade::class,
                'choice_label' => 'name',
                'label' => 'Corps de métier',
                'label_attr' => [
                    'class' => 'col-sm-12 checkbox-inline',
                ],
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label_attr' => ['class' => 'col-sm-12'],
                'attr' => ['placeholder' => 'thierry.gomedj@gmail.com'],
            ])
            ->add('county', EntityType::class, [
                'class' => County::class,
                'choice_label' => 'name',
                'invalid_message' => 'Veuillez choisir un cellule',
                'required' => true,
                'label' => 'Cellule Royaumienne',
                'label_attr' => ['class' => 'col-sm-12'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe',
                    'label_attr' => ['class' => 'col-sm-12'],
                    'attr' => ['placeholder' => 'Mot de passe'],
                ],
                'second_options' => ['label' => 'Entre à nouveau ton mot de passe',
                    'label_attr' => ['class' => 'col-sm-12'],
                    'attr' => ['placeholder' => 'Confirme ton mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisis un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Ton mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
