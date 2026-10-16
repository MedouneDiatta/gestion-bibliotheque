<?php 
declare(strict_types=1);

namespace App\Core;

// La classe gère les routes de l'application et associe une URL à une action
class Router 
{
    private array $routes = [];

    // La méthode qui permet d'enregistrer une route de type GET
    public function get(string $path, mixed $handler): self 
    {
        $this->routes['GET'][$path] = $handler;
        return $this;
    }

    // Permet d'enregistrer une route de type POST
    public function post(string $path, mixed $handler): self 
    {
        $this->routes['POST'][$path] = $handler;
        return $this;
    }

    // Analyse la requête de l'utilisateur et exécute l'action correspondante
    public function resolve(Request $request): mixed 
    {
        $method = $request->getMethod();
        $url = $request->getUrl();
        $handler = $this->routes[$method][$url] ?? null;

        if ($handler === null) {
            http_response_code(404);
            return "<h1>Erreur 404</h1><p>Page introuvable.</p>";
        }

        // Correction : on ajoute les parenthèses () pour exécuter la fonction
        if (is_callable($handler)) {
            return $handler();
        }
         
        if (is_array($handler)) {
            [$controllerClass, $methodName] = $handler;
            $controller = new $controllerClass();
            return $controller->$methodName();
        }

        // Correction : on remplace le point par un point-virgule
        throw new \RuntimeException("Gestionnaire de route invalide.");
    }
}
?>