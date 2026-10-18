<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Service\EmpruntService;
use App\Repository\EmpruntRepository;
use App\Repository\MembreRepository;
use App\Exception\BiblioTechException;

/**
 * La classe EmpruntController gère les requêtes HTTP et les actions web des utilisateurs
 * (affichage des emprunts, emprunter, rendre et prolonger).
 */
final class EmpruntController
{
    /**
     * Le constructeur injecte les dépendances nécessaires à la gestion des emprunts.
     */
    public function __construct(
        private EmpruntService $empruntService,
        private EmpruntRepository $empruntRepository,
        private MembreRepository $membreRepository
    ) {}

    /**
     * Affiche la liste des emprunts en cours pour un membre donné.
     */
    public function mesEmprunts(int $membreId): void 
    {
        try {
            // Récupère les emprunts en cours depuis la base de données
            $emprunts = $this->empruntRepository->findEnCoursPourMembre($membreId);

        } catch (\Throwable $e) {
            $erreur = $e->getMessage();
        }
    }

    /**
     * Traite la demande d'emprunt d'un document par un membre.
     */
    public function emprunter(int $documentId, int $membreId): void 
    {
        try {
            // 1. Récupérer l'entité Membre à partir de son ID
            $membre = $this->membreRepository->find($membreId);

            // 2. Transmettre au service qui exécute les règles métier et enregistre l'emprunt
            $this->empruntService->emprunter($documentId, $membre);

            // 3. Rediriger vers la page des emprunts avec un paramètre de succès
            header('Location: /mes-emprunts?success=1');
            exit();

        } catch (BiblioTechException $e) {
            // En cas de règle métier non respectée (ex: stock épuisé, pénalité impayée)
            $messageErreur = $e->getMessage();
        }
    }

    /**
     * Traite le retour d'un document emprunté.
     */
    public function rendre(int $empruntId): void 
    {
        try {
            // Appelle le service pour marquer l'emprunt comme rendu, calculer la pénalité et réintégrer le stock
            $this->empruntService->rendre($empruntId);

            header('Location: /mes-emprunts?success=retour');
            exit();

        } catch (\Throwable $e) {
            $messageErreur = $e->getMessage();
        }
    }

    /**
     * Traite la prolongation d'un emprunt en cours.
     */
    public function prolonger(int $empruntId): void 
    {
        try {
            // Appelle le service pour repousser la date de retour si les conditions sont validées
            $this->empruntService->prolonger($empruntId);

            header('Location: /mes-emprunts?success=prolonge');
            exit();

        } catch (BiblioTechException $e) {
            $messageErreur = $e->getMessage();
        }
    }
}