<?php


//Definido a pasta raiz do projeto
define("ROOT_PATH", __DIR__ . "/../");
define("DATABASE_FILE", ROOT_PATH . 'database.json');

//requisitando as classes
require_once ROOT_PATH . "Controller/API/BaseController.php";

require_once ROOT_PATH . "/Model/UserModel.php";


?>