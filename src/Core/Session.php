<?php
declare(strict_types=1);

namespace App\Core;

final class Session 
{
    // Une fonction qui s'assure que la session PHP est démarrée sinon on l'active
    public static function start(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Une fonction qui stocke une valeur dans la session sous une clé spécifique
    public static function set(string $key, mixed $value): void 
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    // Récupère une valeur de la session grâce à sa clé
    public static function get(string $key, mixed $default = null): mixed 
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    // Une autre qui vérifie si une clé existe dans la session
    public static function has(string $cle): bool 
    {
        self::start();
        return isset($_SESSION[$cle]); // 
    }

    // Une autre fonction qui supprime une clé de la session
    public static function remove(string $cle): void 
    {
        self::start();
        self::start(); 
        unset($_SESSION[$cle]); 
    }

    // La fonction suivante gère les messages flash
    public static function flash(string $key, mixed $value = null): mixed 
    {
        self::start();
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
            return null;
        }

        $message = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $message;
    }

    // La fonction qui suit regénère l'id de la session pour sécuriser la connexion et éviter le vol de session
    public static function regenerate(): void 
    {
        self::start();
        session_regenerate_id(true);
    }

    // Celle qui suit détruit complètement la session (utilisée lors de la déconnexion)
    public static function destroy(): void 
    {
        self::start();
        session_unset();
        session_destroy();
    }
}
?>