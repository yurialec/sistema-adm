<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsDelete;

/**
 * Editar usuário no banco de dados
 */
class AdmsDeleteTypePage
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    /** Retorna array com os registros do banco de dados @var array */
    private array $resultBd;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function delete(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewTypePage()) {
            $deleteUser = new AdmsDelete();
            $deleteUser->exeDelete("adms_types_pgs", "WHERE id=:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: #008000;'>Registro excluido com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao excluir registro!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    private function viewTypePage(): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT id
                        FROM adms_types_pgs                           
                        WHERE id=:id
                        LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Tipo de Página não encontrada!</p>";
            return false;
        }
    }
}
