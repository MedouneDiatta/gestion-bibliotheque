<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Emprunt;
use App\Entity\Membre;
use App\Repository\DocumentRepository;
use App\Repository\EmpruntRepository;
use App\Exception\LimiteEmpruntAtteinteException;
use App\Exception\DocumentIndisponibleException;
use App\Exception\BiblioTechException;

final class EmpruntService
{
    public function __construct(
        private \PDO $pdo,
        private DocumentRepository $documentRepository,
        private EmpruntRepository $empruntRepository
    ) {}

    /**
     * Enregistre un nouvel emprunt pour un membre.
     */
    public function emprunter(int $documentId, Membre $membre): Emprunt
    {
        // Vérifier si le membre a déjà atteint la limite maximale d'emprunts simultanés (3)
        $empruntsEnCours = $this->empruntRepository->compterEnCoursPourMembre($membre->id);
        if ($empruntsEnCours >= Emprunt::MAX_EMPRUNTS_SIMULTANES) {
            throw new LimiteEmpruntAtteinteException("Le nombre maximal d'emprunts simultanés (" . Emprunt::MAX_EMPRUNTS_SIMULTANES . ") est atteint.");
        }

        //  Vérifier si le membre a des pénalités impayées
        if ($this->empruntRepository->aPenaliteImpayee($membre->id)) {
            throw new BiblioTechException("Impossible d'emprunter : vous avez des pénalités de retard impayées.");
        }

        //  Récupérer et vérifier la disponibilité du document
        $document = $this->documentRepository->find($documentId);
        if (!$document->estDisponible()) {
            throw new DocumentIndisponibleException("Ce document n'est actuellement plus disponible en stock.");
        }

        //  Démarrer une transaction SQL pour garantir la cohérence des données
        $this->pdo->beginTransaction();

        try {
            // Retirer un exemplaire du stock du document
            $document->retirerExemplaire();
            $this->documentRepository->save($document);

            // Calculer la date de retour prévue via le polymorphisme du document
            $dateEmprunt = new \DateTimeImmutable();
            $dateRetourPrevue = $document->calculerDateRetour($dateEmprunt);

            // Créer l'objet Emprunt
            $emprunt = new Emprunt(
                id: null,
                documentId: $documentId,
                membreId: $membre->id,
                dateEmprunt: $dateEmprunt,
                dateRetourPrevue: $dateRetourPrevue,
                dateRetourReelle: null,
                prolonge: false,
                penalite: 0,
                penalitePayee: false,
                statut: \App\Enum\StatutEmprunt::EnCours
            );

            // Enregistrer l'emprunt en base
            $this->empruntRepository->save($emprunt);

            // Valider la transaction
            $this->pdo->commit();

            return $emprunt;

        } catch (\Throwable $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Enregistre le retour d'un document emprunté.
     */
    public function rendre(int $empruntId): Emprunt
    {
        // Récupérer l'emprunt (assure-toi d'avoir une méthode find ou récupère-le via ton repository)
        $emprunt = $this->empruntRepository->find($empruntId);
        if ($emprunt->getStatut() === \App\Enum\StatutEmprunt::Rendu) {
            throw new BiblioTechException("Cet emprunt a déjà été retourné.");
        }

        // Récupérer le document associé pour connaître son tarif de pénalité
        $document = $this->documentRepository->find($emprunt->getDocumentId());

        $dateRetourReelle = new \DateTimeImmutable();
        $dateRetourPrevue = $emprunt->getDateRetourPrevue();

        $penalite = 0;
        $statut = \App\Enum\StatutEmprunt::Rendu;

        //  Calculer le retard et les pénalités si la date réelle dépasse la date prévue
        if ($dateRetourReelle > $dateRetourPrevue) {
            $intervalle = $dateRetourPrevue->diff($dateRetourReelle);
            $joursRetard = (int)$intervalle->days;

            if ($joursRetard > 0) {
                $statut = \App\Enum\StatutEmprunt::EnRetard;
                // Tarif journalier fourni par le polymorphisme du document (ex: Livre = 100 FCFA, Magazine = 50 FCFA, DVD = 200 FCFA)
                $tarifJour = $document->getTarifPenaliteJour();
                $penaliteBrute = $joursRetard * $tarifJour;

                // Plafonner la pénalité à 5000 FCFA (comme défini dans Emprunt::PENALITE_MAX)
                $penalite = min($penaliteBrute, Emprunt::PENALITE_MAX);
            }
        }

        // Démarrer une transaction SQL
        $this->pdo->beginTransaction();

        try {
            // Remettre un exemplaire dans le stock du document
            $document->ajouterExemplaire();
            $this->documentRepository->save($document);

            // Mettre à jour les propriétés de l'emprunt
            $emprunt->setDateRetourReelle($dateRetourReelle);
            $emprunt->setPenalite($penalite);
            $emprunt->setStatut($statut);

            // Sauvegarder l'emprunt mis à jour en base
            $this->empruntRepository->save($emprunt);

            // Valider la transaction
            $this->pdo->commit();

            return $emprunt;

        } catch (\Throwable $e) {
            // Annuler la transaction en cas d'erreur
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Prolonge un emprunt existant d'une durée équivalente, si les conditions sont réunies.
     */
    public function prolonger(int $empruntId): Emprunt
    {
        // Récupérer l'emprunt
        $emprunt = $this->empruntRepository->find($empruntId);

        //  Vérifier si l'emprunt est bien en cours
        if ($emprunt->getStatut() !== \App\Enum\StatutEmprunt::EnCours) {
            throw new BiblioTechException("Impossible de prolonger cet emprunt : il n'est plus actif.");
        }

        //  Vérifier s'il n'a pas déjà été prolongé
        if ($emprunt->isProlonge()) {
            throw new BiblioTechException("Cet emprunt a déjà été prolongé une fois (limite atteinte).");
        }

        //  Vérifier que l'emprunt n'est pas déjà en retard par rapport à la date du jour
        $dateActuelle = new \DateTimeImmutable();
        if ($dateActuelle > $emprunt->getDateRetourPrevue()) {
            throw new BiblioTechException("Impossible de prolonger un emprunt qui est déjà en retard.");
        }

        //  Récupérer le document pour connaître sa durée d'emprunt initiale
        $document = $this->documentRepository->find($emprunt->getDocumentId());
        $dureeJours = $document->getDureeEmpruntJours();

        //  Calculer la nouvelle date de retour prévue (à partir de l'ancienne date prévue ou de la date actuelle)
        $nouvelleDateRetour = $emprunt->getDateRetourPrevue()->modify("+{$dureeJours} days");

        //  Mettre à jour l'emprunt
        $this->pdo->beginTransaction();

        try {
            // Mettre à jour la date de retour prévue et marquer comme prolongé
            // (Assure-toi d'avoir une méthode setDateRetourPrevue dans l'entité Emprunt si elle n'y est pas)
            $emprunt->setDateRetourPrevue($nouvelleDateRetour);
            $emprunt->marquerCommeProlonge();

            // Sauvegarder les modifications via le repository
            $this->empruntRepository->save($emprunt);

            $this->pdo->commit();

            return $emprunt;

        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}