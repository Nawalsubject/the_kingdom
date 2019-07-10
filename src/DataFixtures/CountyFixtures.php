<?php

namespace App\DataFixtures;

use App\Entity\County;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountyFixtures extends Fixture
{
    const COUNTIES = [
        'ORLÉANAIS',
        'TOURRAINE',
        'LYONNAIS',
        'NORMANDIE',
        'ARMORIQUE',
        'BOURGOGNE',
        'AQUITAINE',
        'ALLEMAGNE',
        'CANADA',
        'ESPAGNE',
        'ITALIE',
        'RUSSIE',
        'ROUMANIE',
        'JAPON',
        'INDE',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::COUNTIES as $countyName) {
            $county = new County();
            $county->setName($countyName);
            $manager->persist($county);
        }

        $manager->flush();
    }
}
