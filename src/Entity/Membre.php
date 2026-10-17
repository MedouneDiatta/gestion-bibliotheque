<?php 
  declare(strict_types=1);
  namespace App\Entity;

  final class Membre extends Utilisateur
  {
    public function peutGererCatalogue():bool 
    {
        return false;//parce qu'un memebre ne peu pas modifier les livre
    }

    public function peutGererUtilisateur():bool 
    {
        return false; //un membre ne gère pas les compte
    }
  }
?>