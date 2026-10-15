<?php 
declare(strict_types=1);

namespace App\Exception;

// Exception levée lorsqu'une ressource recherchée n'est pas trouvée (erreur 404)
final class NotFoundException extends BiblioTechException
{
    // Une fonction statique pour créer l'exception avec un message personnalisé
    public static function pour(string $entite, int $id): self {
        return new self(sprintf('%s #%d introuvable.', $entite, $id), 404);
    }
}