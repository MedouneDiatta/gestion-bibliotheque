<?php
declare(strict_types=1);

namespace App\Entity;

abstract class Utilisateur
{
    public function __construct(
        public readonly ?int $id,
        protected string $nom,
        protected string $prenom,
        protected string $email,
        protected string $motDePasse,
        protected string $role,
    ) {}

    // Getters communs
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): string { return $this->role; }

    // Les méthodes abstraites
    abstract public function peutGererCatalogue(): bool;
    abstract public function peutGererUtilisateurs(): bool;
}