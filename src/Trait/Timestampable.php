<?php 
declare(strict_types=1);

namespace App\Trait;

trait Timestampable
{
    // Date et heure de création de l'entité
    protected \DateTimeImmutable $createdAt;
    
    // Date et heure de la dernière mise à jour (nullable)
    protected ?\DateTimeImmutable $updatedAt = null;

    /**
     * Récupère la date de création.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Définit la date de création (par défaut l'instant présent).
     */
    public function setCreatedAt(?\DateTimeImmutable $createdAt = null): void 
    {
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    /**
     * Récupère la date de la dernière mise à jour.
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Met à jour la date de modification à l'instant présent.
     */
    public function mettreAJour(): void 
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}