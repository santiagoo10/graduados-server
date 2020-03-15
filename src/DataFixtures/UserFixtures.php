<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Security\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
         $email = 'renerecalde2@gmail.com';
         $username = 'rene';
         $user = new User($email, $username);
         $roles = [Role::ROLE_ADMIN, Role::ROLE_SUPER_ADMIN, Role::ROLE_USER];

         $user->setRoles($roles);
         $user->setPassword($this->passwordEncoder->encodePassword($user, 'rene'));
         $manager->persist($user);

        $manager->flush();
    }
}
