<h2>Liste des utilisateurs de la bibliothèque</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>ID</th>
            <th>Nom & Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td>#<?= $user->getId() ?? $user->id ?></td>
                <td><?= htmlspecialchars($user->getPrenom() . ' ' . $user->getNom()) ?></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td>
                    <span class="badge"><?= htmlspecialchars($user->getRole()) ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>