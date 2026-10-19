<?php 
declare(strict_types=1);

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\Membre;
use App\Repository\DocumentRepository;
use App\Repository\ReservationRepository;
use App\Exception\BiblioTechException;

/**
 * Gère la logique métier liée aux réservations de documents.
 */
final class ReservationService
{
    public function __construct(
        private \PDO $pdo,
        private DocumentRepository $documentRepository,
        private ReservationRepository $reservationRepository
    ) {}

    /**
     * Permet à un membre de réserver un document.
     */
    public function reserver(int $documentId, Membre $membre): Reservation
    {
        // On vérifie si le document existe
        $document = $this->documentRepository->find($documentId);

        // On vérifie si le membre n'a pas déjà une réservation en attente
        $reservationsEnAttente = $this->reservationRepository->findEnAttenteParDocument($documentId);

        foreach ($reservationsEnAttente as $reservation) {
            if ($reservation->membreId === $membre->id) {
                throw new BiblioTechException("Vous avez déjà une réservation en attente pour ce document.");
            }
        }

        $this->pdo->beginTransaction();
        try {
            $reservation = new Reservation(
                id: null,
                documentId: $documentId,
                membreId: $membre->id,
                dateDemande: new \DateTimeImmutable(),
                statut: 'en_attente'
            );

            $this->reservationRepository->save($reservation);
            $this->pdo->commit();
            
            return $reservation;
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}