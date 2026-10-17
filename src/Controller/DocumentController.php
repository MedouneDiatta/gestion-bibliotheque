<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Repository\DocumentRepository;
use App\Core\View;

class DocumentController
{
    public function index(): string 
    {
        $repo = new DocumentRepository();

        try {
            $documents = $repo->findAll();

            // On appelle notre système de vue en lui passant les données
            return View::render('documents/index', [
                'documents' => $documents
            ]);
        }
        catch (\Exception $e) {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}