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
}
?>