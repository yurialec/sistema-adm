<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsViewAccessLevels
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array|null $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

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

    public function viewLevel(int $id): void
    {
        $this->id = $id;
        $viewAccessLevel = new AdmsRead();
        $viewAccessLevel->fullRead(
            "SELECT id, name, order_levels, created, modified
                FROM adms_access_levels
                WHERE id=:id
                AND order_levels >:order_levels
                LIMIT :limit",
            "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBd = $viewAccessLevel->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nível de acesso não encontrado!<p>";
            $this->result = false;
        }
    }
}
