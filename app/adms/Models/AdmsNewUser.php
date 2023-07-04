<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;

class AdmsNewUser extends AdmsConn
{
    private array|null $data;
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
            $this->vaInput();
        } else {
            $this->result = false;
        }
    }

    private function vaInput(): void
    {
        $valEMail = new AdmsValEmail();
        $valEMail->validateEmail($this->data['email']);

        $valEmailSingle = new AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);

        if (($valEMail->getResult()) and ($valEmailSingle->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    private function add(): void
    {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['user'] = $this->data['email'];
        $this->data['created_at'] = date("Y-m-d H:m:s");

        $createUser = new AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if ($createUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Usuário cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao cadastrar usurário!</p>";
            $this->result = false;
        }
    }
}
