<?php
// src/Controller/Auth/AuthController.php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AuthController extends AbstractController
{
    private $userRepository;
    private $entityManager;
    private $mailer;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'page_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

// AuthController.php
    #[Route(path: '/forgot-password', name: 'page_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('POST')) {
            $email = $request->get('email');
            $user = $this->userRepository->findOneByEmail($email);

            if (!$user) {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
                return $this->redirectToRoute('forgot_password');
            }

            // Génération du resetToken
            $resetToken = Uuid::v4();
            $user->setResetToken($resetToken);
            $this->entityManager->flush();

            // Envoi de l'email
            $resetUrl = $this->generateUrl('reset_password', ['token' => $resetToken], UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new TemplatedEmail())
                ->from('noreply@example.com')
                ->to($user->getEmail())
                ->subject('Réinitialisation du mot de passe')
                ->htmlTemplate('email/reset.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'resetUrl' => $resetUrl,
                ]);

            $this->mailer->send($email);

            $this->addFlash('success', 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.');
            return $this->redirectToRoute('login');
        }

        return $this->render('auth/forgot.html.twig');
    }



    #[Route('/reset', name: 'page_reset_password')]
    public function resetPassword(Request $request, $token)
    {
        $user = $this->userRepository->findOneByResetToken($token);

        if (!$user) {
            $this->addFlash('error', 'Token invalide ou expiré.');
            return $this->redirectToRoute('forgot_password');
        }

        if ($request->isMethod('POST')) {
            $password = $request->get('password');
            $confirmPassword = $request->get('confirm_password');

            if ($password !== $confirmPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('reset_password', ['token' => $token]);
            }

            // Hash le mot de passe et l'enregistre
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $user->setResetToken(null); // Supprime le resetToken
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('login');
        }

        return $this->render('auth/reset.html.twig', ['token' => $token]);
    }

    #[Route('/confirm', name: 'page_confirm_account')]
    public function confirmAccount(): Response
    {
        return $this->render('auth/confirm.html.twig');
    }
}
