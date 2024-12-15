<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:encode-password',
    description: 'Encode un mot de passe pour un utilisateur spécifique',
)]
class EncodeUserPasswordCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'superadmin@test.com']);

        if (!$user) {
            $output->writeln('<error>Utilisateur non trouvé.</error>');
            return Command::FAILURE;
        }

        $encodedPassword = $this->passwordHasher->hashPassword($user, 'NouveauMotDePasse123');
        $user->setPassword($encodedPassword);

        $this->entityManager->flush();

        $output->writeln('<info>Mot de passe encodé avec succès !</info>');
        return Command::SUCCESS;
    }
}
