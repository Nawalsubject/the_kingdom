<?php

namespace App\DataFixtures;

use App\Entity\Trade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TradeFixtures extends Fixture implements DependentFixtureInterface
{
    const TRADES = [
        'Clergé',
        'Intendance',
        'Sénat',
        'Conseil des anciens',
        'Armée',
        'Garde Prétorienne',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TRADES as $key => $tradeName) {
            $trade = new Trade();
            $trade->setName($tradeName);
            for ($i = 0; $i < rand(1, 3); $i++) {
                $trade->addJob($this->getReference('job_' . rand(0, 29)));
            }
            $this->addReference('trade_' . $key, $trade);
            $manager->persist($trade);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [JobFixtures::class];
    }
}
