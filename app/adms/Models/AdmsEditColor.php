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
class AdmsEditColor
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

    public function ViewColor(int $id): void
    {
        $this->id = $id;

        $viewColor = new AdmsRead();
        $viewColor->fullRead(
            "SELECT id, name, color
            FROM adms_colors
            WHERE id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewColor->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Usuário não encontrado!<p>";
            $this->result = false;
        }
    }
    
    public function updateColor(array $data = null): void
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

        $updateColor = new AdmsUpdate();

        $updateColor->exeUpdate("adms_colors", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateColor->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Cor atualizada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não atualizada com sucesso!</p>";
            $this->result = false;
        }
    }
}
