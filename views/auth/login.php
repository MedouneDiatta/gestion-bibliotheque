<?php
// On récupère les éventuelles données transmises par le contrôleur (erreur, ancien email)
$erreur = $erreur ?? null;
$email = $email ?? '';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center mb-4">Connexion à BiblioTech</h2>

                <?php if ($erreur): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>