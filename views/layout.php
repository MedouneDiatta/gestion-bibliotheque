<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioTech - Gestion de Bibliothèque</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f9; color: #333; }
        header { background: #2c3e50; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 1.5rem; }
        .container { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        ul { list-style-type: none; padding: 0; margin: 0; }
        li { padding: 12px 10px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        li:last-child { border-bottom: none; }
        a { color: #2c3e50; text-decoration: none; }
        a:hover { color: #3498db; text-decoration: underline; }
        .badge { background: #3498db; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>
    <header>
        <h1>BiblioTech</h1>
    </header>

    <div class="container">
        <?= $contenu ?? '' ?>
    </div>
</body>
</html>