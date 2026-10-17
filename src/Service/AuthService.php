<?php 
  declare(strict_types=1);

  namespace App\Service;

  use App\Core\Session;
  use App\Entity\Utilisateur;
  use App\Repository\UtilisateurRepository;

  final class AuthService
  {
    public function __construct(private UtilisateurRepository $utilisateurRepository)
    {

    }

    // la fonction suivante permet de retourner un objet utilisateru si les email et le mot de passe sont correcte sinon elle renvoi null
    public function connecter(string $email,string $motDePasse) : ?Utilisateur
    {
        $utilisateur = $this->utilisateurRepository->findParEmail($email);

        if($utilisateur === null)
            {
                return null;
            }

        if(!password_verify($motDePasse,$utilisateur->getMotDePasse()))
            {
                return null;
            }
            Session::regenerate();
            Session::set('utilisateur_id',$utilisateur->getId());
            return $utilisateur;
    }

    // une fonctin qui permet de deconnecter l'utilisateru en detruisant sa session
    public function deconnecter():void 
    {
        Session::destroy();
    }

    // celle ci récupère l'utilisateur actuellemnt connecté depuis la session ou et rtourne null si aucun utilisateur n'est connecté
    public function utilisateurConnecte(): ?Utilisateur 
    {
        $id = Session::get('utilisateur_id');

        if($id === null)
            {
                return null;
            }
        try 
        {
            return $this->utilisateurRepository->find((int)$id);
        }
        catch(\Throwable $e)
        {
            return null;
        }
    }

    // celle ci verifie si un utlilisateru est actuellemnt connecté
    public function estConnecte():bool 
    {
        return Session::has('utilisateur_id');
    }
  }
?>