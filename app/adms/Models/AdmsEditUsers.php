<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmptyField;

/**
 * Editar usuário no banco de dados
 */
class AdmsEditUsers
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    //Recebe os dados
    private array|null $data;

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
        $viewUser->fullRead(
            "SELECT usr.id, usr.name, usr.email, usr.nick_name, usr.user, usr.image
            FROM adms_users as usr
            WHERE usr.id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Usuário não encontrado!<p>";
            $this->result = false;
        }
    }
    public function updateUser(array $data = null): void
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

        if (($valEMail->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $updateUser = new AdmsUpdate();

        $updateUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Usuário atualizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não atualizado com sucesso!</p>";
            $this->result = false;
        }
    }
}
