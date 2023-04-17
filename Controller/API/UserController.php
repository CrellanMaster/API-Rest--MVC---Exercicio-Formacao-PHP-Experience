<?php

class UserController extends BaseController
{

    public function listAction()
    {
        $erroDescription = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $stringParamsArray = $this->getStringParams(); //Utilizo o método getStringParams para receber o array da Query

        //Verifico o método requisitado é GET, utilizando strtoupper para deixar tudo em maiúsculo
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();

                $intLimit = 10;

                //TESTO SE O ARRAY RECEBIDO ALGO DENTRO E SE É DIFERENTE DE NULL
                if (isset($stringParamsArray['limit']) && $stringParamsArray['limit']) {
                    $intLimit = $stringParamsArray['limit'];
                }
                //CHAMO A FUNÇÃO getUsers() utilizando o limite anteriormente obtido
                $usersArray = $userModel->getUsers($intLimit);
                $responseData = json_encode($usersArray);
            } catch (Exception $e) {
                $erroDescription = $e->getMessage();
                $errorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $erroDescription = 'Method not supported';
            $errorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        //sendOutPut

        //TESTO DE TEVE ALGUM ERRO
        if (!$erroDescription) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $erroDescription)), array('Content-type: application/json', $errorHeader));
        }
    }

    public function insertAction()
    {
        $erroDescription = '';
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $stringParams = $this->getStringParams();

        if (strtoupper($requestMethod) === 'POST') {
            try {
                $userModel = new UserModel();

                $data = array();
                if (isset($stringParams['user_id']) && isset($stringParams['username']) && isset($stringParams['user_email']) && isset($stringParams['user_status'])) {
                    $data = $stringParams;
                }
                $insertMessage = $userModel->insertUsers($data['user_id'], $data['username'], $data['user_email'], $data['user_status']);
                $responseData = json_encode($insertMessage);

            } catch (Exception $e) {
                $erroDescription = $e->getMessage();
                $errorHeader = "HTTP/1.1 500 Internal Server Error";
            }
        } else {
            $erroDescription = "Method not supported";
            $errorHeader = "HTTP/1.1 422 Unprocessable Entity';";
        }

        if (!$erroDescription) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $erroDescription)), array('Content-type: application/json', $errorHeader));
        }
    }

}