<?php

namespace App\Form;

use App\Entity\County;
use App\Entity\Trade;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'Thierry'],
                'invalid_message' => 'Saisis ton prénom',
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'Gomedj'],
                'invalid_message' => 'Saisis ton nom',
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
                'label_attr' => ['class' => 'col-md-12'],
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
                'label_attr' => ['class' => 'col-md-12'],
                'widget' => 'single_text',
                'format' => 'yyyy',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => '06123456789'],
            ])
            ->add('trades', EntityType::class, [
                'required' => true,
                'class' => Trade::class,
                'choice_label' => 'name',
                'label' => 'Corps de métier',
                'label_attr' => [
                    'class' => 'col-md-12 checkbox-inline',
                ],
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'thierry.gomedj@gmail.com'],
            ])
            ->add('county', EntityType::class, [
                'class' => County::class,
                'choice_label' => 'name',
                'invalid_message' => 'Veuillez choisir un cellule',
                'required' => true,
                'label' => 'Cellule Royaumienne',
                'label_attr' => ['class' => 'col-md-12'],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => 'Photo de profil',
                'label_attr' => ['class' => 'col-md-12 custom-file'],
                'allow_delete' => false,
                'download_link' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}