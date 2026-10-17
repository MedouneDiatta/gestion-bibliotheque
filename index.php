<?php
declare(strict_types=1);

// 1. On charge l'autoloader unique de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Request;
use App\Core\Router;
use App\Controller\DocumentController;

// 2. On instancie la requête pour écouter l'URL du navigateur
$request = new Request();

// 3. On instancie le routeur
$router = new Router();

// 4. On définit nos routes
$router->get('/Bibliotech/', function() {
    return "<h1>Bienvenue sur l'accueil de Bibliotech ! 📚 (Phase 8)</h1>";
});

// On conserve uniquement la route qui utilise le DocumentController
$router->get('/Bibliotech/documents', [DocumentController::class, 'index']);

// 5. Le routeur analyse l'URL actuelle et exécute l'action correspondante
try {
    $response = $router->resolve($request);
    echo $response; // On affiche le résultat au navigateur
} catch (\Exception $e) {
    http_response_code(500);
    echo "<h1>Erreur serveur</h1><p>" . $e->getMessage() . "</p>";
}