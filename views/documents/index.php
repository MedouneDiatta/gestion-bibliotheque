<h2>Liste des documents</h2>

<!-- Message de succès après l'ajout d'un document -->
<?php if (isset($_SESSION['success'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #c3e6cb;">
         <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Bouton pour accéder au formulaire de création -->
<p>
    <a href="/Bibliotech/documents/create" style="background: #3498db; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-weight: bold;">
        Ajouter un nouveau document
    </a>
</p>

<?php if (!empty($documents)): ?>
    <ul>
        <?php foreach ($documents as $document): ?>
            <li>
                <div>
                    <a href="/Bibliotech/documents/show?id=<?= $document->id ?>" style="text-decoration: none; color: #2c3e50;">
                        <strong><?= htmlspecialchars($document->getTitre()) ?></strong>
                    </a>
                    <small style="color: #666;">(Année : <?= $document->getAnnee() ?>)</small>
                </div>
                <span class="badge"><?= htmlspecialchars($document->getType()) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun document trouvé dans la base de données.</p>
<?php endif; ?>