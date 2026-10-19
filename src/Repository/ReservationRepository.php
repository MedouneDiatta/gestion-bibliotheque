<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;
use App\Exception\NotFoundException;

/**
 * Gère toutes les opérations SQL concernant les réservations de documents.
 * Hérite de AbstractRepository pour bénéficier des méthodes communes.
 */
final class ReservationRepository extends AbstractRepository
{
    protected string $table = 'reservations';

    /**
     * Transforme une ligne brute issue de la base de données en un objet Reservation.
     */
    protected function hydrater(array $ligne): Reservation
    {
        return new Reservation(
            id: (int)$ligne['id'],
            documentId: (int)$ligne['document_id'],
            membreId: (int)$ligne['membre_id'],
            dateDemande: new \DateTimeImmutable($ligne['date_demande']),
            statut: $ligne['statut']
        );
    }

    /**
     * Récupère les réservations en attente pour un document, triées par ordre chronologique.
     * 
     * @return Reservation[]
     */
    public function findEnAttenteParDocument(int $documentId): array 
    {
        $sql = "SELECT * FROM {$this->table} WHERE document_id = :document_id AND statut = 'en_attente' ORDER BY date_demande ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['document_id' => $documentId]);

        $reservations = [];
        while ($ligne = $stmt->fetch()) {
            $reservations[] = $this->hydrater($ligne);
        }
        return $reservations;
    }

    /**
     * Enregistre ou met à jour une réservation en base de données.
     */
    public function save(Reservation $reservation): void 
    {
        if ($reservation->id === null) {
            // Insertion d'une nouvelle réservation
            $sql = "INSERT INTO {$this->table} (document_id, membre_id, date_demande, statut) 
                    VALUES (:document_id, :membre_id, :date_demande, :statut)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'document_id' => $reservation->documentId,
                'membre_id' => $reservation->membreId,
                'date_demande' => $reservation->dateDemande->format('Y-m-d H:i:s'),
                'statut' => $reservation->getStatut()
            ]);
        } else {
            // Mise à jour d'une réservation existante
            $sql = "UPDATE {$this->table} SET statut = :statut WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'statut' => $reservation->getStatut(),
                'id' => $reservation->id
            ]);
        }
    }
}