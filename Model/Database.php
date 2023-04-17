<?php

class Database
{
    protected $conexao;

    public function select($limit): array
    {
        try {
            $users = json_decode(file_get_contents(DATABASE_FILE), true);
            $usersArray = array_slice($users, 0, $limit);

            return $usersArray;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;

    }

    public function insert($user_ID, $username, $user_email, $user_status): string
    {
        try {
            $json_str = file_get_contents(DATABASE_FILE);

            $data = json_decode($json_str, true);

            $data [] = array(
                'user_id' => $user_ID,
                'username' => $username,
                'user_email' => $user_email,
                'user_status' => $user_status
            );

            $json_str = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents(DATABASE_FILE, $json_str);

            return "Dados inseridos com sucesso!";
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

}