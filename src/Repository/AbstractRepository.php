<?php 
declare(strict_types=1);

namespace App\Repository;

use App\Contract\RepositoryInterface;
use App\Core\Database;
use App\Exception\NotFoundException;

// Classe abstraite qui va mutualiser les opérations communes d'accès aux données
abstract class AbstractRepository implements RepositoryInterface 
{
    protected string $table;
    protected \PDO $pdo;

    public function __construct()
    {
        // Récupération de la connexion PDO via notre classe Database
        $this->pdo = Database::getConnection();
    }

    // Méthode abstraite d'hydratation : chaque repository concret saura transformer un tableau SQL brut en objet PHP
    abstract protected function hydrater(array $ligne): object;

    // Méthode qui trouve un enregistrement par son id
    public function find(int $id): object 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if ($ligne === false) {
            throw NotFoundException::pour($this->table, $id);
        }

        return $this->hydrater($ligne);
    }

    // enregistre ou met à jour une entite
    public function save(object $entite):bool
    {
        return true;
    }

    // Récupère tous les enregistrements de la table
    public function findAll(): array 
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        $lignes = $stmt->fetchAll();

        $objets = [];
        foreach ($lignes as $ligne) {
            $objets[] = $this->hydrater($ligne);
        }

        return $objets;
    }

    // Supprime un enregistrement par son id
    public function delete(int $id): bool 
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>