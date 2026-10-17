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
            $document = $repo->find(1);
            $html = "<h1>Liste des documents de la bibliothèque 📚</h1>";

            if ($document) 
            {
                $html .= "<p style='color:green;'>Document trouvé en base : <strong>" . $document->getTitre() . "</strong> (Type : " . $document->getType() . ", Année : " . $document->getAnnee() . ")</p>";
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