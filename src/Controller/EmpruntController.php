<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Service\EmpruntService;
use App\Repository\EmpruntRepository;
use App\Repository\DocumentRepository;
use App\Repository\UtilisateurRepository;
use App\Exception\BiblioTechException;
use PDO;

/**
 * La classe EmpruntController gère les requêtes HTTP et les actions web des utilisateurs
 * (affichage des emprunts, emprunter, rendre et prolonger).
 */
final class EmpruntController
{
    private EmpruntService $empruntService;
    private EmpruntRepository $empruntRepository;
    private UtilisateurRepository $membreRepository;

    /**
     * Le constructeur initialise automatiquement les dépendances.
     */
    public function __construct()
    {
        // 1. Connexion à la base de données
        $pdo = new PDO(
            'mysql:host=localhost;dbname=bibliotech;charset=utf8mb4',
            'root',
            '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        // 2. Instanciation des repositories et services en interne
        $this->empruntRepository = new EmpruntRepository($pdo);
        $documentRepository = new DocumentRepository($pdo);
        $this->membreRepository = new UtilisateurRepository($pdo);
        $this->empruntService = new EmpruntService($pdo, $documentRepository, $this->empruntRepository);
    }

    /**
     * Affiche la liste des emprunts en cours pour un membre donné.
     */
    public function mesEmprunts(): void 
    {
        try {
            // Exemple : ID du membre connecté fixé à 1 pour le test
            $membreId = 1;

            // Récupère les emprunts en cours depuis la base de données
            $emprunts = $this->empruntRepository->findEnCoursPourMembre($membreId);

            // Charger la vue HTML depuis la racine du projet (/views/emprunts/mes-emprunts.php)
            require_once dirname(__DIR__, 2) . '/views/emprunts/mes-emprunts.php';

        } catch (\Throwable $e) {
            $erreur = $e->getMessage();
            require_once dirname(__DIR__, 2) . '/views/emprunts/mes-emprunts.php';
        }
    }

    /**
     * Traite la demande d'emprunt d'un document par un membre.
     */
    public function emprunter(): void 
    {
        try {
            $documentId = (int) ($_POST['document_id'] ?? 0);
            $membreId = 1; // Membre connecté par défaut

            $membre = $this->membreRepository->find($membreId);
            $this->empruntService->emprunter($documentId, $membre);

            header('Location: /Bibliotech/mes-emprunts?success=1');
            exit();

        } catch (BiblioTechException $e) {
            $messageErreur = $e->getMessage();
        }
    }

    /**
     * Traite le retour d'un document emprunté.
     */
    public function rendre(): void 
    {
        try {
            $empruntId = (int) ($_POST['emprunt_id'] ?? 0);

            $this->empruntService->rendre($empruntId);

            header('Location: /Bibliotech/mes-emprunts?success=retour');
            exit();

        } catch (\Throwable $e) {
            $messageErreur = $e->getMessage();
        }
    }

    /**
     * Traite la prolongation d'un emprunt en cours.
     */
    public function prolonger(): void 
    {
        try {
            $empruntId = (int) ($_POST['emprunt_id'] ?? 0);

            $this->empruntService->prolonger($empruntId);

            header('Location: /Bibliotech/mes-emprunts?success=prolonge');
            exit();

        } catch (BiblioTechException $e) {
            $messageErreur = $e->getMessage();
        }
    }
}