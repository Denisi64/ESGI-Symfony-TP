<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création des utilisateurs
        $user = new User();
        $user->setUsername('user1');
        $user->setEmail('user1@example.com');
        // Hashage du mot de passe avec la fonction PHP native
        $hashedPassword = password_hash('password123', PASSWORD_BCRYPT);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        // Administrateur
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@example.com');
        $hashedPassword = password_hash('admin', PASSWORD_BCRYPT);
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
