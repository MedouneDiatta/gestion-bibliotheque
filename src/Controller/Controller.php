<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Core\View;

// La classe abstraite de base qui fournit des raccourcis communs aux contrôleurs
abstract class Controller
{
    /**
     * Raccourci pour afficher une vue avec des données
     */
    protected function view(string $template, array $data = []): string 
    {
        return View::render($template, $data);
    }

    /**
     * Raccourci pour rediriger vers une URL
     */
    protected function redirect(string $url): void 
    {
        header("Location: " . $url);
        exit();
    }

    /**
     * Raccourci pour renvoyer une réponse JSON
     */
    protected function json(mixed $data, int $status = 200): string 
    {
        http_response_code($status);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}   
?>