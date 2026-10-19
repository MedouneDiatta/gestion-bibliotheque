<?php 
  declare(strict_types=1);

  namespace App\Middleware;

  use App\Core\Middleware\MiddlewareInterface;
  use App\Core\Request;
  use App\Core\Response;
  use App\Service\AuthService;

  //   la class qui verifie si l'utilateur est connécté sionon il est redirigé vers la page de connexion
  final class AuthMiddleware implements MiddlewareInterface
  {
    public function __construct(private AuthService $authService)
    {

    }

    public function handle(Request $request,\Closure $next):Response 
    {
        if(!$this->authService->estConnecte())
            {
                return Response::redirect('/login');
            }
            return $next($request);
    }

  }

?>