<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsViewGroupsPages
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

    public function viewGroupsPages(int $id): void
    {
        $this->id = $id;

        $viewTypesPgs = new AdmsRead();
        $viewTypesPgs->fullRead(
            "SELECT id, name, order_group_pg, created, modified
                FROM adms_groups_pgs
                WHERE id =:id
                LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewTypesPgs->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Grupo de página não encontrado!<p>";
            $this->result = false;
        }
    }
}
