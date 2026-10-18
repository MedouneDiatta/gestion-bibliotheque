<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Emprunt;
use App\Enum\StatutEmprunt;
use App\Exception\NotFoundException;
use PDO; 

/**
 * La classe EmpruntRepository est responsable de toutes les interactions 
 * directes avec la table 'emprunts' dans la base de données SQL.
 */
final class EmpruntRepository
{
    /**
     * Le constructeur reçoit l'objet PDO (la connexion à la base de données).
     */
    public function __construct(private PDO $pdo) {}

    /**
     * Compte combien d'emprunts sont actuellement 'en_cours' pour un membre donné.
     * Utilisé pour vérifier la règle des 3 emprunts maximum.
     */
    public function compterEnCoursPourMembre(int $membreId): int 
    {
        // 1. On prépare la requête SQL avec un paramètre sécurisé (:membre_id)
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM emprunts
            WHERE membre_id = :membre_id AND statut = 'en_cours'
        ");

        // 2. On exécute en injectant la véritable valeur
        $stmt->execute(['membre_id' => $membreId]);

        // 3. fetchColumn() retourne le résultat du COUNT(*) converti en entier
        return (int) $stmt->fetchColumn();
    }

    /**
     * Vérifie si un membre a au moins une pénalité non payée.
     * Retourne true s'il y a un blocage, false sinon.
     */
    public function aPenaliteImpayee(int $membreId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM emprunts 
            WHERE membre_id = :membre_id AND penalite > 0 AND penalite_payee = 0
        ");
        $stmt->execute(['membre_id' => $membreId]);

        // Si le total trouvé est supérieur à 0, c'est qu'il a au moins une pénalité impayée
        return ((int) $stmt->fetchColumn()) > 0;
    }

    /**
     * Recherche un emprunt en base de données grâce à son identifiant unique (ID).
     */
    public function find(int $id): Emprunt 
    {
        $stmt = $this->pdo->prepare("SELECT * FROM emprunts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Récupère la ligne sous forme de tableau associatif [ 'id' => 1, 'membre_id' => 5, ... ]
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si aucun emprunt n'a été trouvé avec cet ID, on lève une exception
        if (!$data) {
            throw NotFoundException::pour('Emprunt', $id);
        }

        // On transforme le tableau SQL brut en un objet Emprunt PHP
        return $this->hydrater($data);
    }

    /**
     * Récupère la liste de tous les emprunts actifs ('en_cours') d'un membre.
     * Utile pour afficher son tableau de bord sur l'interface.
     */
    public function findEnCoursPourMembre(int $membreId): array 
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM emprunts
            WHERE membre_id = :membre_id AND statut = 'en_cours'
            ORDER BY date_emprunt DESC
        ");
         
        $stmt->execute(['membre_id' => $membreId]);
        
        // fetchAll() retourne un tableau de plusieurs lignes SQL
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // array_map applique la méthode $this->hydrater sur chaque ligne pour transformer 
        // le tableau de lignes SQL en un tableau d'objets Emprunt
        return array_map(fn(array $row) => $this->hydrater($row), $rows);
    }

    /**
     * Sauvegarde un objet Emprunt en base de données.
     * Si l'ID est null -> c'est un nouvel emprunt (INSERT).
     * Si l'ID existe -> c'est une modification d'un emprunt existant (UPDATE).
     */
    public function save(Emprunt $emprunt): void 
    {
        if ($emprunt->getId() === null) {
            // --- INSERTION D'UN NOUVEL EMPRUNT ---
            $stmt = $this->pdo->prepare("
                INSERT INTO emprunts (document_id, membre_id, date_emprunt, date_retour_prevue, date_retour_reelle, prolonge, penalite, penalite_payee, statut)
                VALUES (:document_id, :membre_id, :date_emprunt, :date_retour_prevue, :date_retour_reelle, :prolonge, :penalite, :penalite_payee, :statut)
            ");

            $stmt->execute([
                'document_id'        => $emprunt->getDocumentId(),
                'membre_id'          => $emprunt->getMembreId(),
                'date_emprunt'       => $emprunt->getDateEmprunt()->format('Y-m-d'),
                'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
                'date_retour_reelle' => $emprunt->getDateRetourReelle()?->format('Y-m-d'),
                'prolonge'           => $emprunt->isProlonge() ? 1 : 0, // Convertit le booléen PHP (true/false) en chiffre SQL (1/0)
                'penalite'           => $emprunt->getPenalite(),
                'penalite_payee'     => $emprunt->isPenalitePayee() ? 1 : 0,
                'statut'             => $emprunt->getStatut()->value, // Récupère la valeur texte de l'enum (ex: 'en_cours')
            ]);
        } else {
            // --- MISE À JOUR D'UN EMPRUNT EXISTANT ---
            $stmt = $this->pdo->prepare("
                UPDATE emprunts 
                SET document_id = :document_id,
                    membre_id = :membre_id,
                    date_emprunt = :date_emprunt,
                    date_retour_prevue = :date_retour_prevue,
                    date_retour_reelle = :date_retour_reelle,
                    prolonge = :prolonge,
                    penalite = :penalite,
                    penalite_payee = :penalite_payee,
                    statut = :statut
                WHERE id = :id
            ");

            $stmt->execute([
                'id'                 => $emprunt->getId(),
                'document_id'        => $emprunt->getDocumentId(),
                'membre_id'          => $emprunt->getMembreId(),
                'date_emprunt'       => $emprunt->getDateEmprunt()->format('Y-m-d'),
                'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
                'date_retour_reelle' => $emprunt->getDateRetourReelle()?->format('Y-m-d'),
                'prolonge'           => $emprunt->isProlonge() ? 1 : 0,
                'penalite'           => $emprunt->getPenalite(),
                'penalite_payee'     => $emprunt->isPenalitePayee() ? 1 : 0,
                'statut'             => $emprunt->getStatut()->value,
            ]);
        }
    }

    /**
     * Méthode d'hydratation (privée) :
     * Convertit un tableau brut de données venant de MySQL (PDO::FETCH_ASSOC)
     * en une vraie instance (objet) de la classe App\Entity\Emprunt.
     */
    private function hydrater(array $data): Emprunt 
    {
        return new Emprunt(
            id: (int) $data['id'],
            documentId: (int) $data['document_id'],
            membreId: (int) $data['membre_id'],
            dateEmprunt: new \DateTimeImmutable($data['date_emprunt']),
            dateRetourPrevue: new \DateTimeImmutable($data['date_retour_prevue']),
            dateRetourReelle: !empty($data['date_retour_reelle']) ? new \DateTimeImmutable($data['date_retour_reelle']) : null,
            prolonge: (bool) $data['prolonge'],
            penalite: (int) $data['penalite'],
            penalitePayee: (bool) $data['penalite_payee'],
            statut: StatutEmprunt::from($data['statut']) // Convertit la chaîne texte SQL vers le bon cas de l'enum StatutEmprunt
        );
    }
}