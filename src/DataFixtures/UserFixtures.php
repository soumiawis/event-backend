<?php

namespace App\DataFixtures;


use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager){

        //role admin
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $userRole = new Role();
        $userRole->setTitle('ROLE_USER');
        $manager->persist($userRole);

        //utilisateur role admin

        $admin = new User();
        $admin->setName('admin')
                  ->setEmail('admin@admin.com')
                  ->setPassword($this->encoder->encodePassword($admin,'admin'))
                  ->addUserRole($adminRole);

        $manager->persist($admin);

        $user = new User();
        $user->setName('user')
            ->setEmail('user@user.com')
            ->setPassword($this->encoder->encodePassword($user,'user'))
            ->addUserRole($userRole);

        $manager->persist($user);



        $manager->flush();
    }
}
