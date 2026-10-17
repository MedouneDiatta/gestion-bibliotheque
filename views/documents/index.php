<h2>Liste des documents</h2>

<?php if (!empty($documents)): ?>
    <ul>
        <?php foreach ($documents as $document): ?>
            <li>
                <div>
                    <!-- Lien propre sans soulignement vers la fiche du document -->
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