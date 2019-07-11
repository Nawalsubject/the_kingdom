<?php

namespace App\DataFixtures;

use App\Entity\County;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountyFixtures extends Fixture
{
    const COUNTIES = [
        'Orléanais',
        'Tourraine',
        'Armorique',
        'Bourgogne',
        'Aquitaine',
        'Lyonnais',
        'Normandie',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::COUNTIES as $key => $countyName) {
            $county = new County();
            $county->setName($countyName);
            $this->addReference('county_' . $key , $county);
            $manager->persist($county);
        }


        $manager->flush();
    }
}
