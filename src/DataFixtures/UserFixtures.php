<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $user->setRoles(["ROLE_ADMIN"]);

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'kingdom'
        ));
        $manager->persist($user);

        $manager->flush();
    }
}
