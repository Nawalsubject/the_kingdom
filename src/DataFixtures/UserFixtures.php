<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('admin@gmail.com');
        $user->setFirstname('Nawal');
        $user->setLastname('Zakarya');
        $user->setEnteredAt(new \DateTime('01-07-2009'));
        $user->setKnightedAt(new \DateTime('01-07-2010'));
        $user->setCounty($this->getReference('county_' . rand(0, 6)));
        $user->setRoles(["ROLE_ADMIN"]);

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'kingdom'
        ));
        $manager->persist($user);

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
        return [CountyFixtures::class];
    }
}
