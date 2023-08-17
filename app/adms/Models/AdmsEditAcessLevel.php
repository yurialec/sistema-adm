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
 * Editar usuário no banco de dados
 */
class AdmsEditAcessLevel
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
    //
    private array $listRecordEdit;

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

    public function ViewAcessLevel(int $id): void
    {
        $this->id = $id;

        $viewAccessLevel = new AdmsRead();
        $viewAccessLevel->fullRead(
            "SELECT id, name, order_levels
            FROM adms_access_levels
            WHERE id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewAccessLevel->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nível de Acesso não encontrado!<p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->edit();
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $updateUser = new AdmsUpdate();

        $updateUser->exeUpdate("adms_access_levels", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Nível de Acesso atualizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao atualizar registro</p>";
            $this->result = false;
        }
    }
}
