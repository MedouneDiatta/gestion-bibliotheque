<?php
declare(strict_types=1);

namespace App\Entity;

final class Administrateur extends Utilisateur
{
    public function peutGererCatalogue(): bool
    {
        return true; // L'administrateur peut tout gérer
    }

    public function peutGererUtilisateurs(): bool
    {
        return true; // L'administrateur peut gérer les utilisateurs
    }
}