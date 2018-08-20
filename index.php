<?php 
header("Access-Control-Allow-Origin: *");
header('Cache-Control: no-cache, must-revalidate'); 
header("Content-Type: text/plain; charset=UTF-8");
header("HTTP/1.1 200 OK");


require_once ("bootstrap.php");

$functions = new \Functions\Functions();
$acao = $functions->load();



/*
$email = [
    "accounts" => ["felipe@wsitebrasil.com.br",
                   "diego@wsitebrasil.com.br",
                   "diego@paranet.com.br",
                   "saulo@wsitebrasil.com.br",
                   "roni@paranet.com.br"],
    "subject"  => "envio de email no CRM",
    "message"  => "<b> vamos enviar email + </b>",
    "anexo"    => [
        "/home/diego/Downloads/wsite.jpg",
        "/home/diego/Downloads/wsite.png"
        ]
];
*/

$dados = file_get_contents("php://input");
$dados1 = (array) json_decode($dados);

__foi($dados1);


function __foi($acao) {
    $dados = (array)$acao["dados"];

    $ret = new \Api\ApiController("sendMail", $dados, "development");
    var_dump($ret);
    return $ret;
}
?>
