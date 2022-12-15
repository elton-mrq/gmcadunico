<?php

namespace App\Http\Middleware;

use App\Session\Admin\SessionLogin;

class RequireAdminLogout
{

    /**
     * Método que executa o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
       //VERIFICA SE O USUARIO ESTA LOGADO
       if(SessionLogin::isLogged()){
          $request->getRouter()->redirect('/admin');
       } 

       //CONTINUA A EXECUÇÃO
       return $next($request);
       
    }

}