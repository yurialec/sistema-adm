<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;

/**
 * alterar ordem do nível de acesso no banco de dados
 */
class AdmsOrderTypePage
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    //Recebe os registro do banco de dados
    private array|null $resultBdPrev;

    private array $data;

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

    public function orderTypePage(int $id): void
    {
        $this->id = $id;

        $viewTypePage = new AdmsRead;
        $viewTypePage->fullRead(
            "SELECT id, order_type_pg
                                        FROM adms_types_pgs
                                        WHERE id=:id
                                        LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewTypePage->getResult();

        if ($this->resultBd) {
            $this->viewPrevTypePage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Tipo de Página não encontrada</p>";
            $this->result = false;
        }
    }

    private function viewPrevTypePage(): void
    {
        $prevAccessLevel = new AdmsRead;
        $prevAccessLevel->fullRead(
            "SELECT id, order_type_pg
                FROM adms_types_pgs
                WHERE order_type_pg <:order_type_pg
                ORDER BY order_type_pg DESC
                LIMIT :limit",
            "order_type_pg={$this->resultBd[0]['order_type_pg']}&limit=1"
        );

        $this->resultBdPrev = $prevAccessLevel->getResult();

        if ($this->resultBdPrev) {
            $this->editMoveDown();
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Tipo de Página não encontrada</p>";
            $this->result = false;
        }
    }

    private function editMoveDown(): void
    {
        $this->data['order_type_pg'] = $this->resultBd[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new AdmsUpdate;
        $moveDown->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBdPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Tipo de Página não encontrada!</p>";
            $this->result = false;
        }
    }

    private function editMoveUp(): void
    {
        $this->data['order_type_pg'] = $this->resultBdPrev[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveUp = new AdmsUpdate;
        $moveUp->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Tipo de Página alterada com sucesso com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro ao editar Tipo de Página!</p>";
            $this->result = false;
        }
    }
}
