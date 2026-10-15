<?php 
declare(strict_types=1);

// On charge l'autoloader unique de Composer (il gère tout tout seul !)
require_once __DIR__ . '/vendor/autoload.php';

use App\Entity\Livre;
use App\Entity\Emprunt;

echo "<h1>======= Test de la Bibliothèque =========</h1>";

try {
    // Ordre respecté : titre, auteur, editeur, annee, exemplairesTotal, exemplairesDispo, isbn, id
    $livre1 = new Livre(
        "Les Misérables", 
        "Victor Hugo", 
        "Gallimard", 
        1862, 
        2, // Exemplaires total
        2, // Exemplaires dispo
        "978-2070409181", 
        1  // ID
    );
    
    echo "<p style='color:green;'>Livre créé : " . $livre1->getTitre() . " (Stock : " . $livre1->getExemplairesDispo() . ")</p>";

    // Premier emprunt par Alice
    $emprunt1 = new Emprunt(1, $livre1, "Alice");
    echo "<p style='color:green;'>Emprunt réussi pour <strong>". $emprunt1->getAdherent() . "</strong>. Stock restant : " . $livre1->getExemplairesDispo() . "</p>";

    // Deuxième emprunt par Bob (épuise le dernier exemplaire)
    $emprunt2 = new Emprunt(2, $livre1, "Bob");
    echo "<p style='color:green;'>Emprunt réussi pour <strong>" . $emprunt2->getAdherent() . "</strong>. Stock restant : " . $livre1->getExemplairesDispo() . "</p>";
    
    // Tentative d'emprunt par Charlie (le stock est à 0, ça doit lever une exception)
    echo "<p>Tentative d'emprunt par Charlie (le stock est à 0)...</p>";
    $emprunt3 = new Emprunt(3, $livre1, "Charlie");

} catch (\DomainException $e) {
    // On attrape l'erreur métier prévue
    echo "<p style='color:red;'><strong>Exception attrapée avec succès : </strong>" . $e->getMessage() . "</p>";
}

// Test de retour d'un livre
if (isset($emprunt1)) {
    echo "<p>Alice rend son livre...</p>";
    $emprunt1->marquerCommeRendu();
    echo "<p style='color:green;'>Livre rendu ! Nouveau stock disponible : " . $livre1->getExemplairesDispo() . "</p>";
}
?>