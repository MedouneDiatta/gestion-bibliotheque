<?php 
declare(strict_types=1);

namespace App\Entity;

class Emprunt
{
    public readonly ?int $id;
    public readonly Livre $livre;
    public readonly string $adherent;
    public readonly \DateTimeImmutable $dateEmprunt;
    private \DateTimeImmutable $dateRetourPrevue; // Correction de l'orthographe
    private ?\DateTimeImmutable $dateRetourEffective;

    public function __construct(
        ?int $id,
        Livre $livre,
        string $adherent,
        ?\DateTimeImmutable $dateEmprunt = null,
        ?\DateTimeImmutable $dateRetourPrevue = null // Correction de l'orthographe
    ) {
        if (!$livre->estDisponible()) {
            throw new \DomainException("Ce livre n'est plus disponible à l'emprunt.");
        }
        
        $livre->retirerExemplaire();
        
        $this->id =$id;
        $this->livre =$livre;

        $adherentNettoye = trim($adherent);
        if ($adherentNettoye === '') {
            throw new \InvalidArgumentException("Le nom de l'adhérent est obligatoire.");
        }
        $this->adherent =$adherentNettoye;

        $this->dateEmprunt =$dateEmprunt ?? new \DateTimeImmutable();

        // Correction de date_modify en modify et utilisation de la bonne variable
        $this->dateRetourPrevue =$dateRetourPrevue ?? $this->dateEmprunt->modify('+14 days');$this->dateRetourEffective = null;
    }

    // --- GETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): Livre 
    {
        return $this->livre; // Correction de $this->Livre ->$this->livre
    }

    public function getAdherent(): string 
    {
        return $this->adherent; // Corrigé (ne renvoie plus la date d'emprunt)
    }

    public function getDateEmprunt(): \DateTimeImmutable 
    {
        return $this->dateEmprunt; // Remis à sa place
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
            throw new \DomainException("Ce livre a déjà été retourné."); // Correction du `:` en `;`
        }

        $this->dateRetourEffective =$dateEffective ?? new \DateTimeImmutable();
        
        $this->livre->ajouterExemplaire();
    }
}
?>