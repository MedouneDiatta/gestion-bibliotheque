<?php 
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\UtilisateurRepository;
use App\Core\View;

final class UtilisateurController
{
    // Affiche tous les utilisateurs / membres
    public function index(): string 
    {
        $repo = new UtilisateurRepository();

        try 
        {
            $utilisateurs = $repo->findAll();

            return View::render('admin/utilisateurs/index', [
                'utilisateurs' => $utilisateurs
            ]);
        }
        catch(\Exception $e)
        {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}
?>