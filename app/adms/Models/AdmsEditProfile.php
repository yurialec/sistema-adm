<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValUserSingle;

/**
 * Visualizar perfil do usuário
 */
class AdmsEditProfile
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    //Recebe os dados
    private array|null $data;
    //Rcebe os campos que serão removidos da validação
    private array|null $dataExitVal;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    /** Retorna os registros do banco de dados @return array|null */
    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewProfile(): void
    {
        $viewUser = new AdmsRead();
        $viewUser->fullRead(
            "SELECT id, name, email, nick_name, user
            FROM adms_users
            WHERE id=:id
            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!<p>";
            $this->result = false;
        }
    }

    public function updateProfile(array $data = null): void
    {
        $this->data = $data;
        $this->dataExitVal['nick_name'] = $this->data['nick_name'];
        unset($this->data['nick_name']);

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
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $_SESSION['user_id']);

        $valUserSingle = new AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $_SESSION['user_id']);

        if (($valEMail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['nick_name'] = $this->dataExitVal['nick_name'];

        $updateProfile = new AdmsUpdate();
        $updateProfile->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);
        
        if ($updateProfile->getResult()) {

            $_SESSION['user_name'] = $this->data['name'];
            $_SESSION['user_nick_name'] = $this->data['nick_name'];
            $_SESSION['user_email'] = $this->data['email'];

            $_SESSION['msg'] = "<p style='color: #008000;'>Perfil atualizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Perfil não atualizado com sucesso!</p>";
            $this->result = false;
        }
    }
}
