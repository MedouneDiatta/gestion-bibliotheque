<?php 
declare(strict_types=1);

namespace App\Controller;

use App\Repository\DocumentRepository;

class DocumentController
{
    public function index(): string 
    {
        $repo = new DocumentRepository();

        try 
        {
            // On récupère tous les documents avec findAll()
            $documents = $repo->findAll();
            $html = "<h1>Liste des documents de la bibliothèque 📚</h1>";

            if (!empty($documents)) 
            {
                $html .= "<ul>";
                foreach ($documents as $document) 
                {
                    $html .= "<li>";
                    $html .= "<strong>" . htmlspecialchars($document->getTitre()) . "</strong> ";
                    $html .= "(Type : " . htmlspecialchars($document->getType()) . ", Année : " . $document->getAnnee() . ")";
                    $html .= "</li>";
                }
                $html .= "</ul>";
            } 
            else 
            {
                $html .= "<p>Aucun document trouvé.</p>";
            }

            return $html;
        }
        catch (\Exception $e) 
        {
            return "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}