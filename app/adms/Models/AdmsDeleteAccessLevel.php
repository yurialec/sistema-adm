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
class AdmsDeleteAccessLevel
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    /** Retorna array com os registros do banco de dados @var array */
    private array $resultBd;
    /** Recebe o endereco para excluir o diretorio da imagem @var string */
    private string $delDirectory;
    /** Recebe o endereco para excluir a imagem @var string */
    private string $delImage;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function delete(int $id): void
    {
        $this->id = (int) $id;

        if ($this->ViewAccessLevel()) {
            $deleteAccessLevel = new AdmsDelete();
            $deleteAccessLevel->exeDelete("adms_access_levels", "WHERE id=:id", "id={$this->id}");

            if ($deleteAccessLevel->getResult()) {
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

    private function ViewAccessLevel(): bool
    {
        $ViewAccessLevel = new \App\adms\Models\helper\AdmsRead();
        $ViewAccessLevel->fullRead(
            "SELECT id
                            FROM adms_access_levels                           
                            WHERE id=:id
                            AND order_levels >:order_levels
                            LIMIT :limit",
            "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBd = $ViewAccessLevel->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nível de Accesso não encontrado!</p>";
            return false;
        }
    }
}
