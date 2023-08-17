<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValPassword;
use App\adms\Models\Helper\AdmsValUserSingle;

class AdmsAddUsers
{
    /** Recebe as informações do formulário @var array|null */
    private array|null $data;
    /** Recebe true quando executar o processo com sucesso @var boolean */
    private bool $result;

    private array $listRecordAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    public function getResult()
    {
        return $this->result;
    }

    public function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    private function valInput(): void
    {
        $valEMail = new AdmsValEmail();
        $valEMail->validateEmail($this->data['email']);

        $valEmailSingle = new AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);

        $valPassowrd = new AdmsValPassword();
        $valPassowrd->validatePassword($this->data['password']);

        $valUserSingleLogin = new AdmsValUserSingle();
        $valUserSingleLogin->validateUserSingle($this->data['user']);

        if (($valEMail->getResult()) and ($valEmailSingle->getResult()) and ($valPassowrd->getResult()) and ($valUserSingleLogin->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    private function add(): void
    {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['conf_email'] = password_hash($this->data['password'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        $this->data['created_at'] = date("Y-m-d H:i:s");

        $createUser = new AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if ($createUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Usuário cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new AdmsRead();
        $list->fullRead("SELECT id as id_sit, name as name_sit FROM adms_sits_users ORDER BY name ASC");
        $records['sit'] = $list->getResult();

        $list->fullRead("SELECT id as id_level, name as name_level
                            FROM adms_access_levels
                            WHERE order_levels >=:order_levels
                            ORDER BY name ASC", "order_levels=" . $_SESSION['order_levels']);
        $records['level'] = $list->getResult();

        $this->listRecordAdd = [
            'sit' => $records['sit'],
            'level' => $records['level']
        ];

        return $this->listRecordAdd;
    }
}
