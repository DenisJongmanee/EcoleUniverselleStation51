<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder=$encoder;

    }

    public function load(ObjectManager $manager): void
    {
        
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->encoder->hashPassword($admin, "adminadmin"));

        $manager->persist($admin);

        $manager->flush();
    }
}
