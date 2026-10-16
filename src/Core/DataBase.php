<?php 
declare(strict_types=1);

namespace App\Core;

// La classe qui gère la connexion à la base de données via PDO
class DataBase 
{
    private static ?\PDO $instance = null;

    // Une fonction qui retourne une instance unique ou une nouvelle instance de connexion PDO
    public static function getConnection(): \PDO 
    {
        if (self::$instance === null) {
            $host = 'localhost';
            $db = 'bibliotech';
            $user = 'root';
            $pass = ''; // Par défaut sous XAMPP, le mot de passe est vide
            $charset = 'utf8mb4';

            // Utilisation de guillemets doubles pour que les variables soient bien lues
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, 
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,       
                \PDO::ATTR_EMULATE_PREPARES   => false,                   
            ];

            try {
                // Bien utiliser $options avec un 's'
                self::$instance = new \PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                throw new \RuntimeException("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>