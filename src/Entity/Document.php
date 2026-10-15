<?php
declare(strict_types=1);

namespace App\Entity;

abstract class Document
{
    protected string $titre;
    protected int $annee;
    protected int $exemplairesTotal;
    protected int $exemplairesDispo;

    public function __construct(
        string $titre,
        int $annee,
        int $exemplairesTotal,
        int $exemplairesDispo,
        public readonly ?int $id = null,
        public readonly string $createdAt = ''
    ) {
        $this->setTitre($titre);
        $this->setAnnee($annee);
        $this->setExemplairesTotal($exemplairesTotal);
        $this->setExemplairesDispo($exemplairesDispo);
    }

    // --- Méthodes abstraites ---
    abstract public function getDureeEmpruntJours(): int;
    abstract public function getTarifPenaliteJour(): int;
    abstract public function getType(): string;

    // --- Méthode commune (polymorphisme) ---
    public function calculerDateRetour(\DateTimeImmutable $debut): \DateTimeImmutable
    {
        return $debut->modify('+' . $this->getDureeEmpruntJours() . ' days');
    }

    // --- Getters et Setters communs ---
    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getAnnee(): int
    {
        return $this->annee;
    }

    public function getExemplairesTotal(): int
    {
        return $this->exemplairesTotal;
    }

    public function getExemplairesDispo(): int
    {
        return $this->exemplairesDispo;
    }

    public function setTitre(string $titre): void
    {
        $titre = trim($titre);
        if ($titre === '') {
            throw new \InvalidArgumentException("Le titre est obligatoire.");
        }
        $this->titre = $titre;
    }

    public function setAnnee(int $annee): void
    {
        $anneeCourante = (int) date('Y');
        if ($annee < 1450 || $annee > $anneeCourante) {
            throw new \InvalidArgumentException("L'année de publication est invalide.");
        }
        $this->annee = $annee;
    }

    public function setExemplairesTotal(int $total): void
    {
        if ($total < 0) {
            throw new \InvalidArgumentException("Le total des exemplaires ne peut pas être négatif.");
        }
        $this->exemplairesTotal = $total;
    }

    public function setExemplairesDispo(int $dispo): void
    {
        if ($dispo < 0) {
            throw new \InvalidArgumentException("Les exemplaires disponibles ne peuvent pas être négatifs.");
        }
        $this->exemplairesDispo = $dispo;
    }

    // --- Méthodes partagées ---
    public function estDisponible(): bool
    {
        return $this->exemplairesDispo > 0;
    }

    public function retirerExemplaire(): void
    {
        if (!$this->estDisponible()) {
            throw new \DomainException("Aucun exemplaire disponible.");
        }
        $this->exemplairesDispo--;
    }

    public function ajouterExemplaire(): void
    {
        if ($this->exemplairesDispo < $this->exemplairesTotal) {
            $this->exemplairesDispo++;
        }
    }
}