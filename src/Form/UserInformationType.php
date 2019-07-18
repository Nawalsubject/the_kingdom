<?php

namespace App\Form;

use App\Entity\County;
use App\Entity\Gender;
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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserInformationType extends AbstractType
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
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'required' => true,
                'label' => 'Genre',
                'choice_label' => 'name',
                'label_attr' => ['class' => 'col-sm-12'],
                'invalid_message' => 'Choisis un genre',
            ])
            ->add('enteredAt', DateType::class, [
                'label' => 'Date d\'entrée au Royaume :',
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
                'label' => 'Date d\'adoubement :',
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
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Photo de profil',
                'label_attr' => ['class' => 'col-sm-12 custom-file'],
                'allow_delete' => false,
                'download_link' => false,
            ])
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ancien mot de passe',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'Votre ancien mot de passe'],
                'invalid_message' => 'Veuillez entrer votre ancien mot de passe.',
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => ['label' => 'Nouveau mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Votre mot de passe', 'class' => 'my-1'],
                ],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Confirmez votre mot de passe', 'class' => 'my-1'],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
