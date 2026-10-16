<?php 
  declare(strict_types=1);

  namespace App\Enum;

//   représente les differentes etats possible d'un emprunt

enum StatusEmprunt : string 
{
    case EnCours = 'en_cours';
    case Rendu = 'rendu';
    case EnRetard = 'en_retard';

    // elle permet de routourner un libelé pour l'affichage

    public function libelle():string 
    {
        return match($this)
        {
            self::EnCours => 'En cours',
            self::Rendu => 'Redu',
            self::EnRetard => 'En retard',
        };
    }

    // la fonction permet de retourner une classe de couleur bootstrap pour l'interface

    public function couleurBadge():string 
    {
        return match($this)
        {
            self::EnCours => 'warning',
            self::Rendu => 'success',
            self::EnRetard => 'danger',
        };
    }
}
?>
