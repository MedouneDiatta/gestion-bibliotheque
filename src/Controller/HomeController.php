<?php 
  declare(strict_types=1);

  namespace App\Controller;

  use App\Core\Response;

   //   la class qui gère la page d'accueil del 'application

   final class HomeController extends Controller
   {
    public function index():Response 
    {
        // on retourn la vue d'accueil 
        return $this->view('home',[
            'titre' => 'Bienvenue sur BiblioTech'
        ]);
    }
   }
?>