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

        // 1. On récupère l'identifiant passé dans l'URL (ex: /documents/show?id=1)
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        try {
            // 2. On demande au Repository de trouver le document par son ID
            // Si l'ID n'existe pas, la méthode find() lèvera une NotFoundException
            $document = $repo->find($id);

            // 3. On transmet le document trouvé à la vue "documents/show"
            return View::render('documents/show', [
                'document' => $document
            ]);
        }
        catch (NotFoundException $e) {
            // Si le document est introuvable (ex: id = 9999)
            return "<p style='color:orange;'> " . $e->getMessage() . "</p><a href='/documents'>Retour à la liste</a>";
        }
        catch (\Exception $e) {
            // Pour toute autre erreur inattendue
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}