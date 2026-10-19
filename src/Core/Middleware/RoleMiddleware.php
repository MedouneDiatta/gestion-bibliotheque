<?php 
  declare(strict_types=1);

  namespace App\Middleware;

  use App\Core\Middleware\MiddlewareInterface;
  use App\Core\Request;
  use App\Core\Response;
  use App\Service\AuthService;
  use App\Exception\AccesRefuseException;

 // la class qui véirifie si l'utilisateur connecté possède le rôle requis pour accéder à la ressource
 final class RoleMiddleware implements MiddlewareInterface
 {
    public function __construct(private AuthService $authService,private string $roleRequis)
    {
      $this->roleRequis = $roleRequis;
    }

    public function handle(Request $request,\Closure $next):Response 
    {
        // on verifie d'abord si l'utilisateur est connécté
       if(!$this->authService->estConnecte())
        {
            return Response::redirect('/login');
        }

        $utilisateur = $this->authService->utilisateur();

        // on verifie si son rôle correspond au role requis
        if($utilisateur->role !== $this->roleRequis)
            {
                throw new AccesRefuseException("Vous n'avez pas les droits neccessaieres pour accèder à cette page");
            }

            return $next($request);

    }
 }  
?>