<!-- CDN Bootstrap Icons pour ajouter de supers icônes vectorielles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
    }

    body {
        background: var(--bg-gradient) !important;
        min-height: 100vh;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .login-container {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-custom {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.25rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
        padding: 2.75rem 2.25rem;
        transition: transform 0.3s ease;
    }

    .brand-logo {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
    }

    .form-group-custom {
        margin-bottom: 1.5rem; /* Espacement aéré entre chaque champ */
    }

    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        letter-spacing: 0.02em;
    }

    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1.1rem;
        color: #9ca3af;
        font-size: 1.1rem;
        transition: color 0.2s ease;
        z-index: 5;
    }

    .form-control-custom {
        width: 100%;
        padding: 0.85rem 1.1rem 0.85rem 3rem; /* Espacement interne confortable pour dégager l'icône */
        font-size: 0.95rem;
        background-color: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        color: #111827;
        transition: all 0.25s ease;
    }

    .form-control-custom:focus {
        outline: none;
        background-color: #ffffff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
    }

    .form-control-custom:focus + .input-icon,
    .input-group-custom:focus-within .input-icon {
        color: var(--primary-color);
    }

    .btn-submit {
        width: 100%;
        padding: 0.9rem;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 20px -3px rgba(79, 70, 229, 0.45);
        background: linear-gradient(135deg, #4338ca, #4f46e5);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .alert-custom {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        border-radius: 0.75rem;
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
</style>

<div class="container login-container">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
            
            <div class="card-custom">
                
                <!-- Logo & Titre -->
                <div class="text-center">
                    <div class="brand-logo">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Bibliotech</h3>
                    <p class="text-muted small mb-4">Entrez vos identifiants pour accéder à la plateforme</p>
                </div>

                <!-- Message d'erreur -->
                <?php if (!empty($erreur)): ?>
                    <div class="alert-custom">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span><?= htmlspecialchars($erreur) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form action="/Bibliotech/login" method="POST">
                    
                    <!-- Champ Email -->
                    <div class="form-group-custom">
                        <label for="email" class="form-label-custom">Adresse e-mail</label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope input-icon"></i>
                            <input 
                                type="email" 
                                class="form-control-custom" 
                                id="email" 
                                name="email" 
                                value="<?= htmlspecialchars($email ?? '') ?>" 
                                placeholder="ex: medoune@bibliotech.com" 
                                required 
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <!-- Champ Mot de Passe -->
                    <div class="form-group-custom" style="margin-bottom: 2rem;">
                        <label for="mot_de_passe" class="form-label-custom">Mot de passe</label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock input-icon"></i>
                            <input 
                                type="password" 
                                class="form-control-custom" 
                                id="mot_de_passe" 
                                name="mot_de_passe" 
                                placeholder="••••••••••••" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Bouton de Soumission -->
                    <button type="submit" class="btn-submit">
                        Se connecter <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>