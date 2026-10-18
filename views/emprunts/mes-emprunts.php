<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Emprunts en cours - BiblioTech</title>
    <!-- Inclusion de Bootstrap pour un design propre et réactif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4">Mes Emprunts en cours</h1>

    <!-- Affichage des messages de confirmation ou de succes -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php if ($_GET['success'] === '1'): ?>
                Votre emprunt a été enregistré avec succès !
            <?php elseif ($_GET['success'] === 'retour'): ?>
                Le document a bien été marqué comme rendu.
            <?php elseif ($_GET['success'] === 'prolonge'): ?>
                Votre emprunt a été prolongé de quelques semaines !
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Affichage des erreurs si la logique métier échoue -->
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger" role="alert">
             <?= htmlspecialchars($erreur) ?>
        </div>
    <?php endif; ?>

    <!-- Tableau de présentation des emprunts -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (empty($emprunts)): ?>
                <p class="text-muted mb-0">Vous n'avez aucun emprunt en cours actuellement.</p>
            <?php else: ?>
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>N° Emprunt</th>
                            <th>ID Document</th>
                            <th>Date d'emprunt</th>
                            <th>Date de retour prévue</th>
                            <th>Statut / Prolongé</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emprunts as $emprunt): ?>
                            <tr>
                                <td>#<?= htmlspecialchars((string)$emprunt->getId()) ?></td>
                                <td>Document #<?= htmlspecialchars((string)$emprunt->getDocumentId()) ?></td>
                                <td><?= $emprunt->getDateEmprunt()->format('d/m/Y') ?></td>
                                <td>
                                    <!-- Si la date de retour est dépassée, on l'affiche en rouge -->
                                    <?php $estEnRetard = new DateTimeImmutable() > $emprunt->getDateRetourPrevue(); ?>
                                    <span class="<?= $estEnRetard ? 'text-danger fw-bold' : '' ?>">
                                        <?= $emprunt->getDateRetourPrevue()->format('d/m/Y') ?>
                                        <?= $estEnRetard ? ' (En retard)' : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($emprunt->isProlonge()): ?>
                                        <span class="badge bg-info text-dark">Prolongé 1 fois</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Initial</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <!-- Bouton / Formulaire pour Prolonger -->
                                    <?php if (!$emprunt->isProlonge() && !$estEnRetard): ?>
                                        <form action="/Bibliotech/prolonger" method="POST" class="d-inline">
                                            <input type="hidden" name="emprunt_id" value="<?= $emprunt->getId() ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                 Prolonger
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <!-- Bouton / Formulaire pour Rendre -->
                                    <form action="/Bibliotech/rendre" method="POST" class="d-inline ms-1">
                                        <input type="hidden" name="emprunt_id" value="<?= $emprunt->getId() ?>">
                                        <button type="submit" class="btn btn-success btn-sm">
                                             Rendre
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>