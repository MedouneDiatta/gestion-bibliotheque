# 📚 BiblioTech - Système de Gestion de Bibliothèque

BiblioTech est une application web moderne développée en PHP 8 (Architecture MVC et Programmation Orientée Objet) permettant de gérer les emprunts, les réservations et le stock de documents au sein d'une bibliothèque.

---

## Fonctionnalités Principales

- **Gestion du Catalogue :** Polimorphisme sur les types de documents (Livres, DVDs).
- **Moteur de Règles Métier (Emprunts) :**
  - Limite stricte de **3 emprunts simultanés** par membre.
  - Blocage des emprunts en cas de **pénalités impayées**.
  - Prolongation unique des prêts en cours (non échus).
  - Plafonnement des pénalités de retard à **5 000 FCFA**.
- **Sécurité et Transaction BDD :** Gestion atomique des stocks et des réservations grâce aux transactions SQL (PDO).
- **Architecture MVC Clean Code :** Séparation nette entre Repositories, Services métiers, Contrôleurs et Vues.

---

## Stack Technique

- **Langage :** PHP 8+ (Strict Types `declare(strict_types=1)`)
- **Base de Données :** MySQL / MariaDB (Driver `PDO`)
- **Serveur Web Local :** Apache / XAMPP
- **Pattern de Conception :** MVC, Singleton (`DataBase`), Repository Pattern, Hydratation d'Objets.

---

## Structure du Projet

```text
bibliotech/
├── config/             # Configuration globale
├── src/
│   ├── Controller/     # Contrôleurs HTTP (EmpruntController, etc.)
│   ├── Core/           # Composants Kernel (DataBase, Controller, View, Router)
│   ├── Entity/         # Entités Métier (Livre, Dvd, Emprunt, Membre)
│   ├── Enum/           # Enumerations (StatutEmprunt, TypeDocument)
│   ├── Exception/      # Exceptions personnalisées (BiblioTechException, etc.)
│   ├── Repository/     # Accès aux données SQL (DocumentRepository, EmpruntRepository)
│   └── Service/        # Logique et règles métier (EmpruntService)
├── views/              # Vues HTML / PHP
├── public/             # Point d'entrée de l'application (index.php)
└── README.md
```
