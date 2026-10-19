<?php
declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Request;
use App\Core\Response;

/**
 * Interface que tous les middlewares doivent implémenter.
 * Elle garantit qu'ils possèdent une méthode handle pour intercepter la requête.
 */
interface MiddlewareInterface
{
    public function handle(Request $request, \Closure $next): Response;
}