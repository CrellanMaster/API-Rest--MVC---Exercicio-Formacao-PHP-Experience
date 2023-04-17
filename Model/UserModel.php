<?php

require_once ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers(int $limit): array
    {

        return $this->select($limit);
    }

    public function insertUsers($user_ID, $username, $user_email, $user_status): string
    {
        return $this->insert($user_ID, $username, $user_email, $user_status);
    }
}