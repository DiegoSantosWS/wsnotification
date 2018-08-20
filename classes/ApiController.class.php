<?php

namespace Api;
use Functions\Functions;
use \SendEmail\SendMail;

class ApiController
{

    private $acao;

    function __construct(string $acao, array $dados, string $ambiente = "developement") {
        
        $this->acao = $acao;
        
        switch ($this->acao) {
            case 'sendMail':
                self::enviandoEmail($dados, $ambiente);
                //echo $return;
                die();
                break;
            
            default:
                # code...
                break;
        }
    }

    private function enviandoEmail($dados, $ambiente) {
        
        $env = new SendMail($dados, $ambiente);
        return $env->returning;
    }
}
