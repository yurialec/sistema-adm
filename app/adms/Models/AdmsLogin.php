<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsRead;

class AdmsLogin extends AdmsConn
{
    private array|null $data;
    private object $conn;
    private $resultDb;
    private $result;

    public function getResult()
    {
        return $this->result;
    }

    public  function login(array $data = null)
    {
        $this->data = $data;
        $viewUser = new AdmsRead();

        //Retorna todas as colunas
        // $viewUser->exeRead("adms_users", "WHERE user =:user LIMIT :limit", "user={$this->data['user']}&limit=1");

        //Retorna somente as colunas indicadas
        $viewUser->fullRead("SELECT id, name, nick_name, email, password, image 
                                FROM adms_users
                                WHERE user =:user OR email =:email LIMIT :limit",
                                "user={$this->data['user']}&email={$this->data['email']}&limit=1");

        $this->resultDb = $viewUser->getResult();

        if ($this->resultDb) {
            $this->valPassword();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Usuário ou senha incorreta!<p>";
            $this->result = false;
        }
    }

    private function valPassword()
    {
        if (password_verify($this->data['password'], $this->resultDb[0]['password'])) {

            $_SESSION['user_id'] = $this->resultDb[0]['id'];
            $_SESSION['user_name'] = $this->resultDb[0]['name'];
            $_SESSION['user_nick_name'] = $this->resultDb[0]['nick_name'];
            $_SESSION['user_email'] = $this->resultDb[0]['email'];
            $_SESSION['user_image'] = $this->resultDb[0]['image'];

            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Usuário ou senha incorreta!<p>";
            $this->result = false;
        }
    }
}
