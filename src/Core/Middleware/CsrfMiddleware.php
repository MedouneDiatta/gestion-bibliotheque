<?php 
  declare(strict_types=1);
  namespace App\Middleware;

  use App\Core\Middleware\MiddlewareInterface;
  use App\Core\Request;
  use App\Core\Response;
  use App\Exception\BiblioTechException;

  //la class qui vérifie la validité du jeton csrf pour toutes les requete modifiants
  final class CsrfMiddleware implements MiddlewareInterface
  {
    public function handle(Request $request,\Closure $next):Response 
    {
        // on protège uniquement les methodes qui modifient des données
        if($request->isPost())
            {
                $tokenSession = $_SESSION['csrf_token'] ?? '';
                $tokenRequest = $request->input('csrf_token', '');

                // si le jeton est absent ou ne correspond pas , on bloque la reqete
                if(empty($tokenSession) || !hash_equals($tokenSession,$tokenRequest))
                    {
                        throw new BiblioTechException("Erreur de sécurité : Jeton CSRF invalide ou expiré.",403);
                    }
            }
            return $next($request);
    }
  }   
?>