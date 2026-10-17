<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioTech - Gestion de Bibliothèque</title>
    <!-- Un peu de CSS simple et propre pour embellir -->
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f9; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 1.5rem; }
        .container { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        li:last-child { border-bottom: none; }
        .badge { background: #3498db; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.85rem; }
    </style>
</head>
<body>
    <header>
        <h1> BiblioTech</h1>
    </header>

    <div class="container">
        <!-- C'est ici que le contenu spécifique de chaque page va s'insérer -->
        <?= $contenu ?? '' ?>
    </div>
</body>
</html>