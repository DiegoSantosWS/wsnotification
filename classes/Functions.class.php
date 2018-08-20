<?php

namespace Functions;


class Functions
{
    public static function load() {
        $method = self::request();
        
        if ($method == 'POST') {
            $acao = filter_input(INPUT_POST, "dados");
        } else if ($method == 'GET') {
            $acao = filter_input(INPUT_GET, "_url", FILTER_SANITIZE_STRING);
        }

        return $acao;
    }

    private function request() {
        return $_SERVER["REQUEST_METHOD"];
    }
}
