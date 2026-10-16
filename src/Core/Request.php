<?php 
  declare(strict_types=1);
  namespace App\Core;

 //   la class represente la requete http envoyé par le navigatuer de l'utilisateur
 class Request
 {
    // elle retourne la methode http utilisé get ou post
    public function getMethod():string 
    {
        return $_SERVER['REQUEST_METHOD']?? 'GET';
    }

    // elle retourn l'url 
    public function getUrl():string 
    {
        $uri = $_SERVER['REQUEST_URI']?? '/';
        $path = parse_url($uri,PHP_URL_PATH);
        return $path !== false? $path : '/';
    }

    // elle verifie si la requete actuelle est de type post
    public function isPost():bool 
    {
        return $this->getMethod() === 'POST';
    }

    // permet de recuperer une valeur envoyé par l'utilisateur via get ou post de manière securisé
    public function input(string $key,mixed $default = null):mixed 
    {
        if(isset($_POST[$key]))
            {
                return $_POST[$key];
            }
        if(isset($_GET[$key]))
            {
                return $_GET[$key];
            }
            return $default;
    }

    // elle retourn toutes les données envoyé par l'utilisateur
    public function all():array 
    {
        return array_merge($_GET,$_POST);
    }
 }
?>