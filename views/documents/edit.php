<?php 
  use App\Entity\Livre;
  use App\Entity\Dvd;
?>

<!-- Lien de retour vers la fiche de détail -->
<p><a href="/Bibliotech/documents/show?id=<?= $document->id ?>">← Retour à la fiche</a></p>

<h2>Modifier le document : <?= htmlspecialchars($document->getTitre()) ?></h2>

<form action="/Bibliotech/documents/update" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; max-width: 600px;">
    
    <!-- l'ID caché -->
    <!-- Il permet à la méthode update() du contrôleur de savoir quel document en BDD on est en train de modifier -->
    <input type="hidden" name="id" value="<?= $document->id ?>">
    
    <!-- Type caché pour info -->
    <input type="hidden" name="type" value="<?= $document instanceof Livre ? 'livre' : 'dvd' ?>">

    <!-- Champs communs (Titre et Année) -->
    <div style="margin-bottom: 15px;">
        <label for="titre" style="display: block; font-weight: bold; margin-bottom: 5px;">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($document->getTitre()) ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="annee" style="display: block; font-weight: bold; margin-bottom: 5px;">Année de publication :</label>
        <input type="number" id="annee" name="annee" value="<?= $document->getAnnee() ?>" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!--  Le polymorphisme dans le formulaire -->
    <!-- Si c'est un Livre, on affiche les champs spécifiques du Livre pré-remplis -->
    <?php if ($document instanceof Livre): ?>
        <div style="margin-bottom: 15px;">
            <label for="auteur" style="display: block; font-weight: bold; margin-bottom: 5px;">Auteur :</label>
            <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($document->getAuteur() ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="editeur" style="display: block; font-weight: bold; margin-bottom: 5px;">Éditeur :</label>
            <input type="text" id="editeur" name="editeur" value="<?= htmlspecialchars($document->getEditeur() ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="isbn" style="display: block; font-weight: bold; margin-bottom: 5px;">ISBN :</label>
            <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($document->getIsbn() ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

    <!-- Si c'est un DVD, on affiche les champs spécifiques du DVD pré-remplis -->
    <?php elseif ($document instanceof Dvd): ?>
        <div style="margin-bottom: 15px;">
            <label for="realisateur" style="display: block; font-weight: bold; margin-bottom: 5px;">Réalisateur :</label>
            <input type="text" id="realisateur" name="realisateur" value="<?= htmlspecialchars($document->getRealisateur() ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="duree_minutes" style="display: block; font-weight: bold; margin-bottom: 5px;">Durée (en minutes) :</label>
            <input type="number" id="duree_minutes" name="duree_minutes" value="<?= $document->getDureeMinutes() ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
    <?php endif; ?>

    <!-- Bouton de soumission -->
    <button type="submit" style="background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
        Enregistrer les modifications
    </button>
</form>