<?php 
declare(strict_types=1);

namespace App\Entity;

class Emprunt
{
    public readonly ?int $id;
    public readonly Document $document; // Remplacé Livre par Document
    public readonly string $adherent;
    public readonly \DateTimeImmutable $dateEmprunt;
    private \DateTimeImmutable $dateRetourPrevue; 
    private ?\DateTimeImmutable $dateRetourEffective;

    public function __construct(
        ?int $id,
        Document $document, // Remplacé Livre par Document
        string $adherent,
        ?\DateTimeImmutable $dateEmprunt = null,
        ?\DateTimeImmutable $dateRetourPrevue = null 
    ) {
        if (!$document->estDisponible()) {
            throw new \DomainException("Ce document n'est plus disponible à l'emprunt.");
        }
        
        $document->retirerExemplaire();
        
        $this->id = $id;
        $this->document = $document;

        $adherentNettoye = trim($adherent);
        if ($adherentNettoye === '') {
            throw new \InvalidArgumentException("Le nom de l'adhérent est obligatoire.");
        }
        $this->adherent = $adherentNettoye;

        $this->dateEmprunt = $dateEmprunt ?? new \DateTimeImmutable();

        // Utilisation de la méthode polymorphe pour calculer la date de retour selon le document (Livre = 21j, DVD = 5j, etc.)
        $this->dateRetourPrevue = $dateRetourPrevue ?? $this->document->calculerDateRetour($this->dateEmprunt);
        $this->dateRetourEffective = null;
    }

    // --- GETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): Document 
    {
        return $this->document; 
    }

    public function getAdherent(): string 
    {
        return $this->adherent; 
    }

    public function getDateEmprunt(): \DateTimeImmutable 
    {
        return $this->dateEmprunt; 
    }

    public function getDateRetourPrevue(): \DateTimeImmutable 
    {
        return $this->dateRetourPrevue;
    }

    public function getDateRetourEffective(): ?\DateTimeImmutable
    {
        return $this->dateRetourEffective;
    }

    // --- MÉTHODES MÉTIER ---

    public function estRendu(): bool 
    {
        return $this->dateRetourEffective !== null;
    }

    public function marquerCommeRendu(?\DateTimeImmutable $dateEffective = null): void 
    {
        if ($this->estRendu()) {
            throw new \DomainException("Ce document a déjà été retourné."); 
        }

        $this->dateRetourEffective = $dateEffective ?? new \DateTimeImmutable();
        
        $this->document->ajouterExemplaire();
    }
}