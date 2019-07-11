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
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('enteredAt', DateType::class, [
                'label' => 'Date d\'entrée au Royaume :',
                'required' => true,
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'text-left',
                    'min' => $dateMin,
                    'max' => $dateMax,
                ],
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'constraints' => new NotBlank(['message' => 'Champ obligatoire']),
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('knightedAt', DateType::class, [
                'label' => 'Date d\'adoubement :',
                'required' => true,
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'text-left',
                    'min' => $dateMin,
                    'max' => $dateMax,
                ],
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'constraints' => new NotBlank(['message' => 'Champ obligatoire']),
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('trades', EntityType::class, [
                'class' => Trade::class,
                'choice_label' => 'name',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('email', EmailType::class)
            ->add('county', EntityType::class, [
                'class' => County::class,
                'choice_label' => 'name',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Mot de passe', 'class' => 'my-1'],
                ],
                'second_options' => ['label' => 'Entre à nouveau ton mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Confirme ton mot de passe', 'class' => 'my-1'],
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
