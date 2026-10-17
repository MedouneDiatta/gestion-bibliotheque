<?php
declare(strict_types=1);

namespace App\Entity;

final class Membre extends Utilisateur
{
    public function peutGererCatalogue(): bool
    {
        return false;
    }

    public function peutGererUtilisateurs(): bool
    {
        return false;
    }
}