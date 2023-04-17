<?php

// CLASSE QUE VAI CONTER MÉTODOS GENÉRICOS RESPONSÁVEIS PELO PROCESSAMENTO DAS REQUISIÇÕES E POR GERAR RESPOSTAS
class BaseController
{

    //Método chamado quando alguém tenta chamar um método que não existe, bom utilizar para chamar o 404
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }


    protected function getStringParams(): array
    {
        //A FUNÇÃO parse_str ANALISE UMA QUERY STRING DE CONSULTA DO TIPO GET OU POST E ARMAZENA EM UMA VARIÁVEL COMO ARRAY ASSOCIATIVO
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }


    //FUNÇÃO QUE VAI RETORNAR OS DADOS DA API PARA O CLIENTE, RECEBENDO DOIS PARAMETROS, UM DELES SENDO $httpHeaders retornando um array
    protected function sendOutput($data, $httpHeaders = array())
    {
        //Utilizamos a função header_remove('Set-Cookie') para remover qualquer cabeçalho set-cookie que possa ter sido definido anteriormente, importante para evitar que o servidor envie Cookies sem autorização. Importante utilizar em erros 404
        header_remove('Set-Cookie');

        //Verificamos se há algum informação de cabelho adicional, testamos isso com a condicional IF, se tivermos, para cada cabeçalho executamos a função header() para enviar os cabeçalhos.
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}