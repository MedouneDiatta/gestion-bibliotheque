<?php 
  declare(strict_types=1);

  namespace App\Core;

   //   la class qui gère la connexion à la base de données via PDO

  class DataBase 
  {
    private static ?\PDO $instance = null;

    // une function qui return une instance unique ou une nouvelle instance de connexion pdo
    public static function getConnection():\PDO 
    {
        if(self::$instance === null)
            {
                $host = 'localhost';
                $db = 'bibliotech';
                $user = 'root';
                $pass = '';//par defaut sous xampp le mot passe est vide
                $dsn = 'mysql:host=$host;dname=$db;charset=$charset';

              $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION, // Lance des exceptions en cas d'erreur SQL
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,       // Récupère les résultats sous forme de tableaux associatifs
                \PDO::ATTR_EMULATE_PREPARES   => false,                   // Utilise les vraies requêtes préparées
            ];

            try
            {
                self::$instance = new \PDO($dsn,$user,$pass,$option);
            }
            catch(\PDOException $e)
            {
                throw new \RuntimeException("Erreur de connexion  à la base de données : " . $e->getMessage());
            }
            }
            return self::$instance;
    }
  }
?>