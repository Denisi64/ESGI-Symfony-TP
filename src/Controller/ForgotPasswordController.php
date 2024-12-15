<?php
// src/Controller/ForgotPasswordController.php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/forgot-password', name: 'forgot_password', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $email = $request->request->get('email');

        if (!$email) {
            $this->addFlash('error', "Veuillez saisir un e-mail.");
            return $this->redirectToRoute('page_forgot_password');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            $this->addFlash('error', "E-mail non trouvé.");
            return $this->redirectToRoute('page_forgot_password');
        }

        $this->addFlash('success', "E-mail vérifié.");
        return $this->redirectToRoute('page_reset_password', ['email' => $email]);
    }

}
