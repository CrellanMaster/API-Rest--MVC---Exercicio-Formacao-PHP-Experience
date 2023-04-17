<?php
//Requisitando o config.php para não precisar ficar chamando todas as classes
require __DIR__ . "/Config/config.php";

//parse_url analisa a URI informada, $_SERVER['REQUEST_URI'] é uma variável global do PHP que contém a URI requisitada pelo cliente, PHP_URL_PATH é um componente que informada para o método parse_url retornar apenas o caminho da URI sem query e host
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// usamos o explode com separador '/' para explodir a string recebida acima pela função parse_url e receber na $uri como um array associativo
$uri = explode('/', $uri);

//Nesse condicional if testamos se a URI na posição um está de acordo com o que queremos, nesse caso que tenha o resultado API ou que a posição 2 tenha V2, isso é para tratar e manipular os resultados que aparecerão de acordo com a URI do cliente, é como um sistema de rotas
if ((isset($uri[1]) && $uri[1] != 'api') || (isset($uri[2]) && $uri[2] != 'v1')) {
    header("HTTP/1.1 404 Not Found");
    exit();
} else if ((isset ($uri[3]) && $uri[3] != "user") || !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require ROOT_PATH . "/Controller/API/UserController.php";

$user = new UserController();
// aqui pegamos a posição 4 da $URI que indica o nosso método, concatenamos com . Action que será o resto do nome do método na classe UserController
$methodName = $uri[4] . 'Action';
//Utilizamos a sintaxe {$methodName} quando o nome do nosso método está sendo definido em tempo de execução e/ou está armazenado em uma variável para que o PHP não tenha problemas de execução.
$user->{$methodName}();