# wsnotification

# Exemplo de uso

```php
$dados = [
    "accounts" => ["email1@seudomain.com.br",
                   "email2@seudomain.com.br",
                   "email3@seudomain.com.br",
                   "email4@seudomain.com.br",
                   "email5@seudomain.com.br"],
    "subject"  => "envio de email no CRM",
    "message"  => "<b> vamos enviar email + </b>",
    "anexo"    => [
        "/home/dir/Downloads/wsite.jpg",
        "/home/dir/Downloads/wsite.png"
        ]
];
```

# Exemplo Recebendo

```php
$dados = file_get_contents("php://input");
$dados1 = (array) json_decode($dados);


__foi($dados1);


function __foi($acao) {
    $dados = (array)$acao["dados"];

    $ret = new \Api\ApiController("sendMail", $dados, "development");
    var_dump($ret);
    return $ret;
}
```