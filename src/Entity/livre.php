<?php
declare(strict_types=1);

namespace App\Entity;

final class Livre extends Document
{
    private string $auteur;
    private string $editeur;
    public readonly string $isbn;

    public function __construct(
        string $titre,
        string $auteur,
        string $editeur,
        int $annee,
        int $exemplairesTotal,
        int $exemplairesDispo,
        string $isbn,
        ?int $id = null
    ) {
        // On envoie les infos communes au constructeur parent (Document)
        parent::__construct($titre, $annee, $exemplairesTotal, $exemplairesDispo, $id);
        
        $this->setAuteur($auteur);
        $this->setEditeur($editeur);
        $this->isbn = trim($isbn);
    }

    // --- Implémentation des méthodes abstraites obligatoires ---

    public function getDureeEmpruntJours(): int
    {
        return 21; // Un livre se garde 21 jours selon le cahier des charges[cite: 1]
    }

    public function getTarifPenaliteJour(): int
    {
        return 100; // 100 FCFA par jour de retard[cite: 1]
    }

    public function getType(): string
    {
        return 'livre';
    }

    // --- Getters et Setters spécifiques au Livre ---

    public function getAuteur(): string { return $this->auteur; }
    public function getEditeur(): string { return $this->editeur; }

    public function setAuteur(string $auteur): void
    {
        $auteur = trim($auteur);
        if ($auteur === '') {
            throw new \InvalidArgumentException("L'auteur est obligatoire.");
        }
        $this->auteur = $auteur;
    }

    public function setEditeur(string $editeur): void
    {
        $this->editeur = trim($editeur);
    }

    // foncton qui ajoute cette methode si elle manquait
    public function getIsbn():? string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn):void 
    {
        $this->isbn=$isbn;
    }
}