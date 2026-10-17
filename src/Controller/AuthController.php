<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Service\AuthService;

final class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    // La fonction qui affiche le formulaire de connexion avec GET /login
    public function loginForm(Request $request): Response 
    {
        if ($this->authService->estConnecte()) {
            return $this->redirect('/documents');
        }
        return $this->view('auth/login');
    }

    // La fonction qui traite la soumission du formulaire de connexion
    public function login(Request $request): Response 
    {
        $email = $request->input('email', '');
        $motDePasse = $request->input('mot_de_passe', ''); // Corrigé : input au lieu de intput

        // Tentative de connexion via le service
        $utilisateur = $this->authService->connecter($email, $motDePasse);

        if ($utilisateur === null) {
            return $this->view('auth/login', [ // Corrigé : ajout de la virgule après 'auth/login'
                'erreur' => 'Email ou mot de passe incorrect.',
                'email' => $email
            ]);
        }

        return $this->redirect('/documents');
    }

    // La fonction qui déconnecte l'utilisateur avec GET /logout
    public function logout(Request $request): Response 
    {
        $this->authService->deconnecter();
        return $this->redirect('/login');
    }
}