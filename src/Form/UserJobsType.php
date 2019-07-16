<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\User;
use App\Repository\JobRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserJobsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jobs', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'name',
                'query_builder' => function (JobRepository $jobRepository) {
                    return $jobRepository->createQueryBuilder('j')
                        ->leftJoin('j.trade', 't')
                        ->addOrderBy('t.name')
                        ->addOrderBy('j.name');
                },
                'choice_attr' => function ($job) {
                    if ($job->getTrade() !== null) {
                        return ['trade' => $job->getTrade()->getName()];
                    }
                    return ['trade' => 'Aucun corps de métier'];
                },
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
