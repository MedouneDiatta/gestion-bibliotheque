<?php 
  use App\Entity\Livre;
  use App\Entity\Dvd;
?>

<!-- Bouton pour revenir à la liste complète -->
<p><a href="/Bibliotech/documents">← Retour à la liste des documents</a></p>

<h2> Fiche de détail : <?= htmlspecialchars($document->getTitre()) ?></h2>

<div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-top: 15px;">
    <p><strong>Identifiant :</strong> #<?= $document->id ?></p>
    <p><strong>Type :</strong> <span class="badge"><?= htmlspecialchars($document->getType()) ?></span></p>
    <p><strong>Année de publication :</strong> <?= $document->getAnnee() ?></p>
    <p><strong>Exemplaires disponibles :</strong> <?= $document->getExemplairesDispo() ?> / <?= $document->getExemplairesTotal() ?></p>

    <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">

    <!-- Affichage spécifique selon la sous-classe (Polymorphisme) -->
    <?php if ($document instanceof Livre): ?>
        <h3>Détails du Livre</h3>
        <p><strong>Auteur :</strong> <?= htmlspecialchars($document->getAuteur() ?? 'Non renseigné') ?></p>
        <p><strong>Éditeur :</strong> <?= htmlspecialchars($document->getEditeur() ?? 'Non renseigné') ?></p>
        <p><strong>ISBN :</strong> <?= htmlspecialchars($document->getIsbn() ?? 'N/A') ?></p>
    <?php elseif ($document instanceof Dvd): ?>
        <h3>Détails du DVD</h3>
        <p><strong>Réalisateur :</strong> <?= htmlspecialchars($document->getRealisateur() ?? 'Non renseigné') ?></p>
        <p><strong>Durée :</strong> <?= $document->getDureeMinutes() ?> minutes</p>
    <?php endif; ?>
</div>

<!-- Boutons d'action -->
<div style="margin-top: 20px;">
    <a href="/Bibliotech/documents/delete?id=<?= $document->id ?>" 
       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');" 
       style="background: #e74c3c; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">
         Supprimer ce document
    </a>
</div>