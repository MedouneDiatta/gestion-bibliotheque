<?php 
declare(strict_types=1);

// On charge l'autoloader unique de Composer (il gère tout tout seul !)
require_once __DIR__ . '/vendor/autoload.php';

use App\Entity\Livre;
use App\Entity\Emprunt;
use App\Entity\Dvd;

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

    // test de création d'un dvd

    $dvd1= new Dvd("Inception","Christopher Nolan",148,2010,3,2);
    echo "<p style='color:green;'>DVD créé : " . $dvd1->getTitre() . " (Durée d'emprunt : " . $dvd1->getDureeEmpruntJours() . " jours) | Ajouté le : " . $dvd1->getCreatedAt()->format('Y-m-d H:i:s') . "</p>";

    // on test l'emprunt polymprque d'un dvd par alice
    $empruntDvd = new Emprunt(1,$dvd1,"Alice");
    echo "<p style='color:green;'>Emprunt du DVD réussi pour <strong>" . $empruntDvd->getAdherent() . "</strong>. Retour prévu le : " . $empruntDvd->getDateRetourPrevue()->format('Y-m-d') . "</p>";

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

// --- Test de la fabrique statique et des constantes de la Phase 5 ---
echo "<h1>=====Test de la fabrique statique et des constante dela phase 5======</h1>";
    echo "<p style='color:blue;'><strong>Test Phase 5 (Constants & Static) :</strong></p>";
    echo "<p>Nombre max d'emprunts autorisés : " . Emprunt::MAX_EMPRUNTS_SIMULTANES . "</p>";
    echo "<p>Pénalité maximale : " . Emprunt::PENALITE_MAX . " FCFA</p>";

    // Utilisation du constructeur statique (fabrique)
    $empruntStatique = Emprunt::nouveau(5, $livre1, "Mariama");
    echo "<p style='color:green;'>Emprunt créé via la fabrique statique pour <strong>" . $empruntStatique->getAdherent() . "</strong></p>";

    echo "<h1>======Test pour las cas d'excetptions======</h1>";

    
    echo "<p style='color:blue;'><strong>Test Phase 6 (Exceptions) :</strong></p>";
    
    try {
        // On simule une recherche d'un document qui n'existe pas en base (ex: ID 999)
        $idRecherche = 999;
        // Si on ne trouve rien, on lance notre exception personnalisée :
        throw \App\Exception\NotFoundException::pour('Document', $idRecherche);

    } catch (\App\Exception\NotFoundException $e) {
        // On attrape l'exception et on affiche son message et son code HTTP
        echo "<p style='color:orange;'><strong>Exception attrapée :</strong> " . $e->getMessage() . " (Code HTTP : " . $e->getCode() . ")</p>";
    }

     echo "<h1>======Test Document Respository======</h1>";

    // --- Test de la Phase 7 : DocumentRepository et MySQL ---
    echo "<p style='color:blue;'><strong>Test Phase 7 (Repository & MySQL) :</strong></p>";

    try {
        // On instancie notre repository (le "bibliothécaire" de la base de données)
        $docRepo = new \App\Repository\DocumentRepository();

        // On va chercher le document avec l'ID 1 qu'on vient d'insérer dans MySQL
        $monLivre = $docRepo->find(1);

        echo "<p style='color:green;'>Livre récupéré depuis la base de données : <strong>" . $monLivre->getTitre() . "</strong> (Année : " . $monLivre->getAnnee() . ")</p>";

    } catch (\Exception $e) {
        echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    }
?>