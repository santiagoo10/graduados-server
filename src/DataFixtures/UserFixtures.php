<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Security\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles([Role::ROLE_ADMIN, Role::ROLE_SUPER_ADMIN, Role::ROLE_USER]);
        $user->setEmail('admin@graduados.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
               '$argon2id$v=19$m=65536,t=4,p=1$WXHRng8mENLgU3qRGQPRkw$/YZoPQzDyZLMIkfmrychEhOxG28gs6wWYGNnGT5Bsak'
            ));
        //pass=123456
        $manager->persist($user);
        $manager->flush();


    }
}
