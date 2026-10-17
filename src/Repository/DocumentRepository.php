<?php 
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Document;
use App\Entity\Livre;
use App\Entity\Dvd;
use App\Enum\TypeDocument;

final class DocumentRepository extends AbstractRepository
{
    protected string $table = "documents";

    // Transforme un tableau associatif SQL brut en un objet concret (Livre, Dvd, etc.)
    protected function hydrater(array $ligne): Document
    {
        $type = TypeDocument::from($ligne['type']);

        return match($type)
        {
            TypeDocument::Livre => new Livre(
                titre: $ligne['titre'],
                auteur: $ligne['auteur'] ?? '',
                editeur: $ligne['editeur'] ?? '',
                annee: (int) $ligne['annee'],
                exemplairesTotal: (int) $ligne['exemplaires_total'],
                exemplairesDispo: (int) $ligne['exemplaires_dispo'],
                isbn: $ligne['isbn'] ?? '',
                id: (int) $ligne['id']
            ),
            TypeDocument::Dvd => new Dvd(
                titre: $ligne['titre'],
                réalisateur: $ligne['realisateur'] ?? '',
                dureeMinutes: (int) ($ligne['duree_minutes'] ?? 0),
                annee: (int) $ligne['annee'],
                exemplairesTotal: (int) $ligne['exemplaires_total'],
                exemplairesDispo: (int) $ligne['exemplaires_dispo'],
                id: (int) $ligne['id']
            ),
            default => throw new \InvalidArgumentException("Type de document inconnu : " . $ligne['type'])
        };
    }

    //  Implémentation de la méthode save pour insérer un Document en BDD
    public function save(object $entite): bool
    {
        if (!$entite instanceof Document) {
            throw new \InvalidArgumentException("L'entité passée à save() doit être un Document.");
        }

        // Requête SQL d'insertion (grâce à $this->pdo héritée d'AbstractRepository)
        $sql = "INSERT INTO {$this->table} (titre, annee, type, exemplaires_total, exemplaires_dispo, auteur, editeur, isbn, realisateur, duree_minutes) 
                VALUES (:titre, :annee, :type, :exemplaires_total, :exemplaires_dispo, :auteur, :editeur, :isbn, :realisateur, :duree_minutes)";

        $stmt = $this->pdo->prepare($sql);

        // Initialisation des variables optionnelles
        $auteur = null;
        $editeur = null;
        $isbn = null;
        $realisateur = null;
        $dureeMinutes = null;
        $typeStr = '';

        // Extraction des données selon la classe concrète (Livre ou Dvd)
        if ($entite instanceof Livre) {
            $typeStr = 'livre';
            $auteur = $entite->getAuteur();
            $editeur = $entite->getEditeur();
            $isbn = $entite->getIsbn();
        } elseif ($entite instanceof Dvd) {
            $typeStr = 'dvd';
            $realisateur = $entite->getRealisateur();
            $dureeMinutes = $entite->getDureeMinutes();
        }

        // Exécution de la requête préparée de manière sécurisée contre les injections SQL
        return $stmt->execute([
            'titre' => $entite->getTitre(),
            'annee' => $entite->getAnnee(),
            'type' => $typeStr,
            'exemplaires_total' => $entite->getExemplairesTotal(),
            'exemplaires_dispo' => $entite->getExemplairesDispo(),
            'auteur' => $auteur,
            'editeur' => $editeur,
            'isbn' => $isbn,
            'realisateur' => $realisateur,
            'duree_minutes' => $dureeMinutes
        ]);
    }
}
?>