<?php

namespace App\adms\Models;

use App\adms\Controllers\ViewUsers;
use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsValEmptyField;
use PDO;

class AdmsNewUser extends AdmsConn
{
    private array|null $data;
    private object $conn;
    private $resultDb;
    private $result;

    public function getResult()
    {
        return $this->result;
    }

    public  function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->conn = $this->connectionDb();

            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);

            $query_new_user = "INSERT INTO adms_users (name, email, user, password, created_at) VALUES (:name, :email, :user, :password, NOW())";

            $add_new_user = $this->conn->prepare($query_new_user);
            $add_new_user->bindValue(":name", $this->data['name'], PDO::PARAM_STR);
            $add_new_user->bindValue(":email", $this->data['email'], PDO::PARAM_STR);
            $add_new_user->bindValue(":user", $this->data['email'], PDO::PARAM_STR);
            $add_new_user->bindValue(":password", $this->data['password'], PDO::PARAM_STR);

            $add_new_user->execute();

            if ($add_new_user->rowCount()) {
                $_SESSION['msg'] = "<p style='color: #008000;'>Usuário cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao cadastrar usurário!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
}
