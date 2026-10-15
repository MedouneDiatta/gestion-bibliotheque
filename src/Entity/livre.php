<?php
declare(strict_types=1);

namespace App\Entity;

class Livre
{
    private string $titre;
    private string $auteur;
    private string $editeur;
    private int $annee;
    private int $exemplairesDispo; // Nom harmonisé au pluriel

    public function __construct(
        string $titre,
        string $auteur,
        string $editeur,
        int $annee,
        public readonly ?int $id,
        public readonly string $isbn,
        int $exemplairesDispo = 1 // Ajouté dans le constructeur avec une valeur par défaut
    ) {
        $this->setTitre($titre);
        $this->setAuteur($auteur);
        $this->setEditeur($editeur);
        $this->setAnnee($annee);
        $this->setExemplairesDispo($exemplairesDispo);
    }

    // --- GETTERS ---

    public function getTitre(): string 
    {
        return $this->titre;
    }

    public function getAuteur(): string 
    {
        return $this->auteur;
    }

    public function getEditeur(): string
    {
        return $this->editeur; 
    }

    public function getAnnee(): int 
    {
        return $this->annee;
    }

    public function getExemplairesDispo(): int 
    {
        return $this->exemplairesDispo;
    }

    // --- SETTERS AVEC VALIDATION ---

    public function setTitre(string $titre): void 
    {
        $titre = trim($titre);
        if ($titre === '') {
            throw new \InvalidArgumentException("Le titre du livre est obligatoire.");
        }
        $this->titre = $titre;
    }

    public function setAuteur(string $auteur): void 
    {
        $auteur = trim($auteur);
        if ($auteur === '') {
            throw new \InvalidArgumentException("L'auteur du livre est obligatoire.");
        }
        $this->auteur = $auteur;
    }

    public function setEditeur(string $editeur): void 
    {
        $this->editeur = trim($editeur);
    }

    public function setAnnee(int $annee): void 
    {
        $anneeCourante = (int) date('Y'); // Définition de l'année courante
        if ($annee < 1450 || $annee > $anneeCourante) {
            throw new \InvalidArgumentException("L'année de publication est invalide.");
        }
        $this->annee = $annee; // Correction de la faute de frappe sur la variable ($annnee -> $annee)
    }

    public function setExemplairesDispo(int $exemplairesDispo): void 
    {
        if ($exemplairesDispo < 0) {
            throw new \InvalidArgumentException("Le nombre d'exemplaires ne peut pas être négatif.");
        }
        $this->exemplairesDispo = $exemplairesDispo; // Assignation de la valeur qui manquait
    }

    // --- MÉTHODES MÉTIER ---

    public function estDisponible(): bool 
    {
        return $this->exemplairesDispo > 0;
    }

    public function retirerExemplaire(): void 
    {
        if (!$this->estDisponible()) {
            throw new \DomainException("Aucun exemplaire disponible à l'emprunt.");
        }
        $this->exemplairesDispo--;
    }

    public function ajouterExemplaire(): void 
    {
        $this->exemplairesDispo++;
    }
}