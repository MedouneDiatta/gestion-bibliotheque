<?php 
declare(strict_types=1);

namespace App\Core;

class View 
{
    // On met la méthode en static pour l'appeler directement : View::render(...)
    public static function render(string $vue, array $donnees = []): string 
    {
        // On extrait les données pour qu'elles deviennent des variables accessibles dans la vue
        extract($donnees);

        // CORRECTION : Ajout du point manquant avant le slash et correction du nom du dossier "views"
        $cheminVue = __DIR__ . '/../../views/' . $vue . '.php';

        if (!file_exists($cheminVue)) {
            throw new \Exception("La vue '{$vue}' est introuvable dans {$cheminVue}");
        }

        // On démarre la temporisation de sortie pour capturer le contenu de la vue
        ob_start();
        require $cheminVue;
        $contenu = ob_get_clean();

        // On inclut le layout principal qui va enrober le contenu
        $cheminLayout = __DIR__ . '/../../views/layout.php';
        if (file_exists($cheminLayout)) {
            ob_start();
            require $cheminLayout;
            return ob_get_clean();
        }
        
        return $contenu;
    }
}
?>