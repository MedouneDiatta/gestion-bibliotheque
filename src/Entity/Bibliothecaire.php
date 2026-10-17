<?php
declare(strict_types=1);

namespace App\Entity;

final class Bibliothecaire extends Utilisateur
{
    public function peutGererCatalogue(): bool
    {
        return true; // Le bibliothécaire peut gérer les livres
    }

    public function peutGererUtilisateurs(): bool
    {
        return false; // Il ne gère pas les comptes utilisateurs
    }
}