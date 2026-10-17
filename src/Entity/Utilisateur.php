<?
   declare(strict_types=1);
   namespace App\Entity;

   abstract class Utilisateur
   {
    public function __construct
    (
        public readonly ?int $id,
        protected string $nom,
        protected string $prenom,
        protected string $email,
        protected string $motDePasse,
        protected string $role,
    )
    {}

    // getter communs
    public function getNom():string {return $this->nom;}

    public function getPrenom():string {return $this->prenom;}

    public function getEmail():string {return $this->email;}

    public function getRole():string  {return $this->role;}

    // les methode abstaites que les sous classe devront obligatoirement implémentés
    abstract public function peutGererCatalogue():bool;
    abstract public function peutGrererUtilisateur():bool;

   }
?>