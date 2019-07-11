<?php

namespace App\DataFixtures;

use App\Entity\Trade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TradeFixtures extends Fixture
{
    const TRADES = [
        'CLERGÉ',
        'GARDE PRETORIENNE',
        'INTENDANCE',
        'SÉNAT',
        'CONSEIL DES ANCIENS',
        'ARMÉE',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TRADES as $key => $tradeName) {
            $trade = new Trade();
            $trade->setName($tradeName);
            $this->addReference('trade_' . $key, $trade);
            $manager->persist($trade);
        }

        $manager->flush();
    }
}