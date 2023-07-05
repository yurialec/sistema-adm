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

        //Retorna somente as colunas indicadas
        $viewUser->fullRead(
            "SELECT id, name, nick_name, email, password, image, adms_sits_user_id
                                FROM adms_users
                                WHERE user =:user OR email =:email LIMIT :limit",
            "user={$this->data['user']}&email={$this->data['user']}&limit=1"
        );

        $this->resultDb = $viewUser->getResult();

        if ($this->resultDb) {
            $this->valEmailPermission();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Usuário ou senha incorreta!<p>";
            $this->result = false;
        }
    }

    private function valEmailPermission(): void
    {
        if ($this->resultDb[0]['adms_sits_user_id'] == 1) {
            $this->valPassword();
        } elseif ($this->resultDb[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Necessário confirmar o e-mail!<p>";
            $this->result = false;
        } elseif ($this->resultDb[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! E-mail descadastrado, por favor entre em contato com a empresa!<p>";
            $this->result = false;
        } elseif ($this->resultDb[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! E-mail inativo, por favor entre em contato com a empresa!<p>";
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! E-mail inativo, por favor entre em contato com a empres!<p>";
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
