<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmptyField;

/**
 * Editar situação no banco de dados
 */
class AdmsEditSitsUsers
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

    public function ViewSitsUser(int $id): void
    {
        $this->id = $id;

        $viewUser = new AdmsRead();
        $viewUser->fullRead(
            "SELECT id, name, adms_color
            FROM adms_sits_users
            WHERE id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Situação não encontrada!<p>";
            $this->result = false;
        }
    }

    public function updateSitsUser(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $updateSitsUser = new AdmsUpdate();
        $updateSitsUser->exeUpdate("adms_sits_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateSitsUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Situação atualizada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao atualizar situação!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new AdmsRead();
        $list->fullRead("SELECT id as id_color, name as name_color FROM adms_colors ORDER BY name ASC");
        $records['color'] = $list->getResult();

        $this->listRecordEdit = ['color' => $records['color']];

        return $this->listRecordEdit;
    }
}
