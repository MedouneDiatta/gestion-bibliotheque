<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Repository\DocumentRepository;
use App\Core\View;
use App\Exception\NotFoundException;
use App\Entity\Livre;
use App\Entity\Dvd;

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
        $isbn = $_POST['isbn'] ?? '';

        $repo = new DocumentRepository();

        try {
            if ($type === 'livre') {
                $document = new Livre(
                    titre: $titre,
                    auteur: $auteur,
                    editeur: $editeur,
                    annee: $annee,
                    exemplairesTotal: 3,
                    exemplairesDispo: 3,
                    isbn: $isbn
                );
            } else {
                $document = new Dvd(
                    titre: $titre,
                    realisateur: $_POST['realisateur'] ?? 'Inconnu',
                    dureeMinutes: (int)($_POST['duree_minutes'] ?? 120),
                    annee: $annee,
                    exemplairesTotal: 3,
                    exemplairesDispo: 3
                );
            }

            $repo->save($document);

            $_SESSION['success'] = "Le document a été ajouté avec succès !";

            header('Location: /Bibliotech/documents');
            exit();
        }
        catch (\Exception $e) {
            echo "<p style='color:red;'>Erreur lors de l'enregistrement : " . $e->getMessage() . "</p>";
        }
    }

    // Supprime un document par son id
    public function delete(): void 
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $repo = new DocumentRepository();

        try {
            $repo->delete($id);
            $_SESSION['success'] = "Le document a été supprimé avec succès !";
        }
        catch(\Exception $e) {
            $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
        }

        header('Location: /Bibliotech/documents');
        exit();
    }

    // Affiche le formulaire de modification pré-rempli
    public function edit(): string 
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $repo = new DocumentRepository(); // CORRECTION : $repo au lieu de $rep

        try {
            $document = $repo->find($id);

            return View::render('documents/edit', [
                'document' => $document
            ]);
        }
        catch(\Exception $e) {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }

    // Traite la modification et met à jour en BDD
    public function update(): void 
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $titre = $_POST['titre'] ?? '';
        $annee = isset($_POST['annee']) ? (int)$_POST['annee'] : 0;
        $type = $_POST['type'] ?? 'livre';

        $repo = new DocumentRepository();

        try {
            $document = $repo->find($id);

            // Mise à jour des propriétés communes
            $document->setTitre($titre);
            $document->setAnnee($annee);

            // Si c'est un livre ou un DVD, on met à jour les champs spécifiques
            if ($document instanceof \App\Entity\Livre) {
                $document->setAuteur($_POST['auteur'] ?? '');
                $document->setEditeur($_POST['editeur'] ?? '');
                $document->setIsbn($_POST['isbn'] ?? '');
            } 
            elseif ($document instanceof \App\Entity\Dvd) {
                $document->setRealisateur($_POST['realisateur'] ?? '');
                // $document->setCategorie($_POST['categorie'] ?? ''); // Décommente si la méthode existe
            }

            // On sauvegarde les modifications dans la base de données
            $repo->save($document);

            $_SESSION['success'] = "Le document a été modifié avec succès !";
            header('Location: /Bibliotech/documents/show?id=' . $id);
            exit();
        }
        catch(\Exception $e) {
            echo "<p style='color:red;'>Erreur lors de la mise à jour : " . $e->getMessage() . "</p>";
        }
    }
}