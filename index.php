<?php
declare(strict_types=1);
session_start();

// 1. On charge l'autoloader unique de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Request;
use App\Core\Router;
use App\Controller\HomeController;
use App\Controller\DocumentController;
use App\Controller\Admin\UtilisateurController;
use App\Controller\AuthController;
use App\Controller\EmpruntController;
use App\Controller\ReservationController; // Si tu as ce contrôleur

// On instancie la requête pour écouter l'URL du navigateur
$request = new Request();

// On instancie le routeur
$router = new Router();

// --- ACCUEIL ---
$router->get('/Bibliotech/', [HomeController::class, 'index']);

// --- DOCUMENTS ---
$router->get('/Bibliotech/documents', [DocumentController::class, 'index']);
$router->get('/Bibliotech/documents/show', [DocumentController::class, 'show']);
$router->get('/Bibliotech/documents/create', [DocumentController::class, 'create']);
$router->post('/Bibliotech/documents/store', [DocumentController::class, 'store']);
$router->get('/Bibliotech/documents/delete', [DocumentController::class, 'delete']);
$router->get('/Bibliotech/documents/edit', [DocumentController::class, 'edit']);
$router->post('/Bibliotech/documents/update', [DocumentController::class, 'update']);

// --- AUTHENTIFICATION ---
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// --- EMPRUNTS ---
$router->get('/Bibliotech/mes-emprunts', [EmpruntController::class, 'mesEmprunts']);
$router->post('/Bibliotech/emprunter', [EmpruntController::class, 'emprunter']);
$router->post('/Bibliotech/rendre', [EmpruntController::class, 'rendre']);
$router->post('/Bibliotech/prolonger', [EmpruntController::class, 'prolonger']);

// --- ADMINISTRATION ---
$router->get('/Bibliotech/admin/utilisateurs', [UtilisateurController::class, 'index']);

// --- RÉSERVATIONS (Optionnel selon tes fichiers) ---
// $router->get('/Bibliotech/reservations', [ReservationController::class, 'index']);
// $router->post('/Bibliotech/reserver', [ReservationController::class, 'store']);

// Le routeur analyse l'URL actuelle et exécute l'action correspondante
try {
    $response = $router->resolve($request);
    echo $response; 
} catch (\Exception $e) {
    http_response_code(500);
    echo "<h1>Erreur serveur</h1><p>" . $e->getMessage() . "</p>";
}