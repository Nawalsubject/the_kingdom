<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JobFixtures extends Fixture
{
    const JOBS = [
        'Seigneur',
        'Sénateur',
        'Suppléant',
        'Intendant',
        'Conseiller',
        'Pape',
        'Bailli',
        'Artisan',
        'Maître cuisinier',
        'Cuisinier',
        'Maître Bâtisseur',
        'Franc-Pochtron',
        'Baron',
        'Apprentis Baron',
        'Maître Brasseur',
        'Brasseur',
        'Tavernier',
        'Apprentis tavernier',
        'Cardinal',
        'Inquisiteur',
        'Infirmier',
        'Vétérant',
        'Sénéchal',
        'Capitaine',
        'Sergent',
        'Garde',
        'Préfet du Prétoire',
        'Centurion',
        'Sergent prétorien',
        'Garde prétorien',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::JOBS as $key => $jobName) {
            $job = new Job();
            $job->setName($jobName);
            $this->addReference('job_' . $key, $job);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
