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
class AdmsOrderAccessLevels
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

    public function orderAccessLevels(int $id): void
    {
        $this->id = $id;
        $viewAccessLevel = new AdmsRead;
        $viewAccessLevel->fullRead(
            "SELECT id, order_levels
                                        FROM adms_access_levels
                                        WHERE id=:id
                                        AND order_levels >:order_levels
                                        LIMIT :limit",
            "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBd = $viewAccessLevel->getResult();

        if ($this->resultBd) {
            $this->viewPrevAccessLevel();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Nível de Acesso não encontrado</p>";
            $this->result = false;
        }
    }

    private function viewPrevAccessLevel(): void
    {
        $prevAccessLevel = new AdmsRead;
        $prevAccessLevel->fullRead(
            "SELECT id, order_levels
                FROM adms_access_levels
                WHERE order_levels <:order_levels
                AND order_levels >:order_level_user
                ORDER BY order_levels DESC
                LIMIT :limit",
            "order_levels={$this->resultBd[0]['order_levels']}&order_level_user=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBdPrev = $prevAccessLevel->getResult();

        if ($this->resultBdPrev) {
            $this->editMoveDown();
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Nível de Acesso não encontrado</p>";
            $this->result = false;
        }
    }

    private function editMoveDown(): void
    {
        $this->data['order_levels'] = $this->resultBd[0]['order_levels'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new AdmsUpdate;
        $moveDown->exeUpdate("adms_access_levels", $this->data, "WHERE id=:id", "id={$this->resultBdPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro ao editar Nível de Acesso!</p>";
            $this->result = false;
        }
    }

    private function editMoveUp(): void
    {
        $this->data['order_levels'] = $this->resultBdPrev[0]['order_levels'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveUp = new AdmsUpdate;
        $moveUp->exeUpdate("adms_access_levels", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Nível de acesso alterado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro ao editar Nível de Acesso!</p>";
            $this->result = false;
        }
    }
}
