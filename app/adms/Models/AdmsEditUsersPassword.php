<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValPassword;

/**
 * Editar usuário no banco de dados
 */
class AdmsEditUsersPassword
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
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

    public function ViewUser(int $id): void
    {
        $this->id = $id;

        $viewUser = new AdmsRead();
        $viewUser->fullRead("SELECT id FROM adms_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Usuário não encontrado!<p>";
            $this->result = false;
        }
    }
    
    public function updateUserPass(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->valInput();
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    private function valInput(): void
    {
        $valPassword = new AdmsValPassword();
        $valPassword->validatePassword($this->data['password']);

        if (($valPassword->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['modified'] = date("Y-m-d H:i:s");
        $updateUserPass = new AdmsUpdate();

        $updateUserPass->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateUserPass->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Senha atualizada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não atualizada com sucesso!</p>";
            $this->result = false;
        }
    }
}
