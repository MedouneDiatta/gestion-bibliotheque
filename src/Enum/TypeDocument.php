<?php
 declare(strict_types=1);
 
 namespace App\Enum;

 use App\Entity\Document;
 use App\Entity\Livre;
 use App\Entity\Dvd;

//  l'enu represente les types de document disponibles dans la bibliotheque

enum TypeDocument:string 
{
    case Livre = 'livre';
    case Magazine = 'magazine';
    case Dvd = 'dvd';

    // la fonction suivante permet de returner un libellé lisible pour l'affichage

    public function libelle():string 
    {
        return match($this)
        {
            self::Livre => 'Livre',
            self::Magazine => 'Magazine',
            self::Dvd => 'DVD',
        };
    }
}
?>