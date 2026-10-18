<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\StatutEmprunt;

final class Emprunt
{
    public const MAX_EMPRUNTS_SIMULTANES = 3;
    public const PENALITE_MAX = 5000;

    public function __construct(
        public readonly ?int $id,
        public readonly int $documentId,
        public readonly int $membreId,
        public readonly \DateTimeImmutable $dateEmprunt,
        private \DateTimeImmutable $dateRetourPrevue,
        private ?\DateTimeImmutable $dateRetourReelle = null,
        private bool $prolonge = false,
        private int $penalite = 0,
        private bool $penalitePayee = false,
        private StatutEmprunt $statut = StatutEmprunt::EnCours
    ) {}

    // --- GETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function getMembreId(): int
    {
        return $this->membreId;
    }

    public function getDateEmprunt(): \DateTimeImmutable
    {
        return $this->dateEmprunt;
    }

    public function getDateRetourPrevue(): \DateTimeImmutable
    {
        return $this->dateRetourPrevue;
    }

    public function getDateRetourReelle(): ?\DateTimeImmutable
    {
        return $this->dateRetourReelle;
    }

    public function isProlonge(): bool
    {
        return $this->prolonge;
    }

    public function getPenalite(): int
    {
        return $this->penalite;
    }

    public function isPenalitePayee(): bool
    {
        return $this->penalitePayee;
    }

    public function getStatut(): StatutEmprunt
    {
        return $this->statut;
    }

    // --- SETTERS / MÉTHODES MÉTIER ---

    public function setDateRetourReelle(?\DateTimeImmutable $dateRetourReelle): void
    {
        $this->dateRetourReelle = $dateRetourReelle;
    }

    public function setPenalite(int $penalite): void
    {
        $this->penalite = $penalite;
    }

    public function setStatut(StatutEmprunt $statut): void
    {
        $this->statut = $statut;
    }

    public function marquerCommeProlonge(): void
    {
        $this->prolonge = true;
    }

    public function setDateRetourPrevue(\DateTimeImmutable $dateRetourPrevue): void
    {
        $this->dateRetourPrevue = $dateRetourPrevue;
    }
}