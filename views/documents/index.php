<h2>Liste des documents</h2>

<?php if (!empty($documents)): ?>
    <ul>
        <?php foreach ($documents as $document): ?>
            <li>
                <div>
                    <strong><?= htmlspecialchars($document->getTitre()) ?></strong> 
                    <small>(Année : <?= $document->getAnnee() ?>)</small>
                </div>
                <span class="badge"><?= htmlspecialchars($document->getType()) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun document trouvé dans la base de données.</p>
<?php endif; ?>