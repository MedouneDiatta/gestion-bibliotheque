<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Repository\DocumentRepository;
use App\Core\View;
use App\Exception\NotFoundException;

class DocumentController
{
    // Affiche la liste de tous les documents
    public function index(): string 
    {
        $repo = new DocumentRepository();

        try {
            $documents = $repo->findAll();

            return View::render('documents/index', [
                'documents' => $documents
            ]);
        }
        catch (\Exception $e) {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }

    // Affiche la fiche détaillée d'un seul document
    public function show(): string
    {
        $repo = new DocumentRepository();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        try {
            $document = $repo->find($id);

            return View::render('documents/show', [
                'document' => $document
            ]);
        }
        catch (NotFoundException $e) {
            // CORRECTION : Ajout de /Bibliotech/ dans le lien de retour
            return "<p style='color:orange;'> " . $e->getMessage() . "</p><a href='/Bibliotech/documents'>Retour à la liste</a>";
        }
        catch (\Exception $e) {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }

    // Affiche le formulaire de création
    public function create(): string 
    {
        return View::render('documents/create');
    }

    // Traite la soumission du formulaire et enregistre en BDD
   public function store(): void 
    {
        $titre = $_POST['titre'] ?? '';
        $annee = isset($_POST['annee']) ? (int)$_POST['annee'] : 0;
        $type = $_POST['type'] ?? 'livre';
        $auteur = $_POST['auteur'] ?? null;
        $editeur = $_POST['editeur'] ?? null;

        $repo = new DocumentRepository();

        try {
            if ($type === 'livre') {
                // On instancie un objet Livre
                $document = new Livre(
                    titre: $titre,
                    auteur: $auteur,
                    editeur: $editeur,
                    annee: $annee,
                    exemplairesTotal: 3, // Valeur par défaut par exemple
                    exemplairesDispo: 3
                );
            } else {
                // Si c'est un DVD
                $document = new Dvd(
                    titre: $titre,
                    realisateur: $_POST['realisateur'] ?? 'Inconnu',
                    dureeMinutes: (int)($_POST['duree_minutes'] ?? 120),
                    annee: $annee,
                    exemplairesTotal: 3,
                    exemplairesDispo: 3
                );
            }

            // On sauvegarde en base de données
            $repo->save($document);

            // Redirection vers la liste après succès
            header('Location: /Bibliotech/documents');
            exit();
        }
        catch (\Exception $e) {
            echo "<p style='color:red;'>Erreur lors de l'enregistrement : " . $e->getMessage() . "</p>";
        }
    }
}