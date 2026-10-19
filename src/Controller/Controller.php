<?php 
  declare(strict_types=1);

  namespace App\Controller;

  use App\Core\Response;
  use App\Core\View;

  //la class abstraite de base qui fournisse des raccourcis communs aux controllers
  abstract class Controller
  {
    // une functin qui permet le racourcis pour afficher une vue avec des donnes
    protected function view(string $template,array $data=[]):Response 
    {
        return Response::view($template,$data);
    }

    // celle ci permet le racourcis pour rediriger vers une url
    protected function redirect(string $url):Response 
    {
        return Response::redirect($url);
    }

    // celle ci pour renvoyer une réponse json
    protected function json(mixed $data,int $status=200):Response 
    {
          return Response::json($data,$status);
    }
  }   
?>