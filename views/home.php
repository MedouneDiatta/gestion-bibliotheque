<!-- CDN Bootstrap Icons -->
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

    .home-container {
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
        padding: 3rem 2.5rem;
        transition: transform 0.3s ease;
    }

    .brand-logo {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
    }

    .btn-action-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff !important;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        border-radius: 0.75rem;
        text-decoration: none !important; /* Supprime le soulignement */
        transition: all 0.25s ease;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-action-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 20px -3px rgba(79, 70, 229, 0.45);
        background: linear-gradient(135deg, #4338ca, #4f46e5);
        color: #ffffff !important;
        text-decoration: none !important;
    }

    .btn-action-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151 !important;
        background-color: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        text-decoration: none !important; /* Supprime le soulignement */
        transition: all 0.25s ease;
    }

    .btn-action-outline:hover {
        background-color: #ffffff;
        border-color: var(--primary-color);
        color: var(--primary-color) !important;
        transform: translateY(-1px);
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="container home-container">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            
            <div class="card-custom text-center">
                
                <!-- Logo & Titre -->
                <div>
                    <div class="brand-logo">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-2" style="letter-spacing: -0.02em;">Bienvenue sur BiblioTech</h2>
                    <p class="text-muted small mb-4 px-md-3">
                        Votre application de gestion de bibliothèque moderne et intuitive pour suivre vos documents et vos emprunts en toute simplicité.
                    </p>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <p class="mb-4 text-secondary fw-semibold small text-uppercase" style="letter-spacing: 0.05em;">Que souhaitez-vous faire ?</p>
                
                <!-- Boutons d'action -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="/Bibliotech/documents" class="btn-action-primary flex-fill">
                        <i class="bi bi-journal-text"></i> Catalogue
                    </a>
                    <a href="/login" class="btn-action-outline flex-fill">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>