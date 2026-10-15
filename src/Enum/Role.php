<?php 
declare(strict_types=1);

namespace App\Enum;

// Représente les différents rôles possibles pour un utilisateur dans BiblioTech
enum Role: string 
{
    case Membre = 'membre';
    case Bibliothecaire = 'bibliothecaire';
    case Admin = 'admin';

    public function libelle(): string 
    {
        return match($this) {
            self::Membre => 'Membre',
            self::Bibliothecaire => 'Bibliothécaire',
            self::Admin => 'Administrateur',
        };
    }
}