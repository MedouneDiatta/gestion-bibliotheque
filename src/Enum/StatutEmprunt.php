<?php 
declare(strict_types=1);

namespace App\Enum;

// Représente les différents états possibles d'un emprunt
enum StatutEmprunt : string 
{
    case EnCours = 'en_cours';
    case Rendu = 'rendu';
    case EnRetard = 'en_retard';

    // Permet de retourner un libellé pour l'affichage
    public function libelle(): string 
    {
        return match($this) {
            self::EnCours => 'En cours',
            self::Rendu => 'Rendu',      // Correction de la faute de frappe ici
            self::EnRetard => 'En retard',
        };
    }

    // Permet de retourner une classe de couleur Bootstrap pour l'interface
    public function couleurBadge(): string 
    {
        return match($this) {
            self::EnCours => 'warning',
            self::Rendu => 'success',
            self::EnRetard => 'danger',
        };
    }
}