<?php
declare(strict_types=1);

namespace App\Entity;

final class Dvd extends Document
{
    private string $réalisateur;
    private int $dureeMinutes;

    public function __construct(
        string $titre,
        string $réalisateur,
        int $dureeMinutes,
        int $annee,
        int $exemplairesTotal,
        int $exemplairesDispo,
        ?int $id = null
    ) {
        parent::__construct($titre, $annee, $exemplairesTotal, $exemplairesDispo, $id);
        $this->réalisateur = $réalisateur;
        $this->dureeMinutes = $dureeMinutes;
    }

    public function getDureeEmpruntJours(): int
    {
        return 5; // Un DVD se garde 5 jours[cite: 1]
    }

    public function getTarifPenaliteJour(): int
    {
        return 200; // 200 FCFA de pénalité[cite: 1]
    }

    public function getType(): string
    {
        return 'dvd';
    }
}