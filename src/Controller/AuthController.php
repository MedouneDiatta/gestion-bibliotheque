<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Core\Request;
use App\Service\AuthService;
use App\Repository\UtilisateurRepository; // <-- N'oublie pas l'import
use App\Core\View;

final class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        // On instancie AuthService en lui fournissant son UtilisateurRepository
        $this->authService = new AuthService(new UtilisateurRepository());
    }

    // Affiche le formulaire de connexion (GET /login)
    public function loginForm(): string 
    {
        if ($this->authService->estConnecte()) {
            header('Location: /Bibliotech/documents');
            exit();
        }
        return View::render('auth/login');
    }

    // Traite la soumission du formulaire de connexion (POST /login)
    public function login(): void 
    {
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        $utilisateur = $this->authService->connecter($email, $motDePasse);

        if ($utilisateur === null) {
            echo View::render('auth/login', [
                'erreur' => 'Email ou mot de passe incorrect.',
                'email' => $email
            ]);
            return;
        }

        header('Location: /Bibliotech/documents');
        exit();
    }

    // Déconnecte l'utilisateur (GET /logout)
    public function logout(): void 
    {
        $this->authService->deconnecter();
        header('Location: /Bibliotech/login');
        exit();
    }
}