<?php

namespace App\Http\Middleware;

class Maintenance
{

    /**
     * Método que executa o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
       if(getenv('MAINTENANCE') == 'true'){
        throw new \Exception('Sistema em Manutenção. Tente novamente mais tarde!', 200);
       }
       
       return $next($request);
    }
}