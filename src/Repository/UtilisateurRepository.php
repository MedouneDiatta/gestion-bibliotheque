<?php 
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Membre;
use App\Entity\Bibliothecaire;
use App\Entity\Administrateur;

final class UtilisateurRepository extends AbstractRepository
{
    protected string $table = 'utilisateurs'; // 👈 Corrigé au pluriel (utilisateurs)

    protected function hydrater(array $ligne): Utilisateur
    {
        return match($ligne['role'])
        {
            'admin' => new Administrateur(
                (int)$ligne['id'], 
                $ligne['nom'], 
                $ligne['prenom'], 
                $ligne['email'], 
                $ligne['mot_de_passe'], 
                $ligne['role']
            ),
            'bibliothecaire' => new Bibliothecaire(
                (int)$ligne['id'], 
                $ligne['nom'], 
                $ligne['prenom'], 
                $ligne['email'], 
                $ligne['mot_de_passe'], 
                $ligne['role']
            ),
            default => new Membre(
                (int)$ligne['id'], 
                $ligne['nom'], 
                $ligne['prenom'], 
                $ligne['email'], 
                $ligne['mot_de_passe'], 
                $ligne['role']
            ),
        };
    }

    public function findParEmail(string $email): ?Utilisateur
{
    $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $ligne = $stmt->fetch();

    if ($ligne === false) {
        return null;
    }

    return $this->hydrater($ligne);
}
}