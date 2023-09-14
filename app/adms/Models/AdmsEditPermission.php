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
 * Editar permissao
 */
class AdmsEditPermission
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

    public function editPermission(int $id): void
    {
        $this->id = $id;

        $viewPermission = new AdmsRead();
        $viewPermission->fullRead(
            "SELECT lev_pag.id, lev_pag.permission
                            FROM adms_levels_pages lev_pag
                            INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id 
                            WHERE lev_pag.id =:id
                            AND lev.order_levels >:order_levels
                            LIMIT :limit",
            "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBd = $viewPermission->getResult();

        if ($this->resultBd) {
            $this->edit();
        } else {
            $_SESSION['msg'] = "<p class=alert-danger'>Erro: Necessário selecionar uma página válida!<p>";
            $this->result = false;
        }
    }

    private function edit(): void
    {
        if ($this->resultBd[0]['permission'] == 1) {
            $this->data['permission'] = 2;
        } else {
            $this->data['permission'] = 1;
        }

        $this->data['modified'] = date("Y-m-d H:i:s");

        $updatPermission = new AdmsUpdate();
        $updatPermission->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->id}");

        if ($updatPermission->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Permissão editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro ao editar permissão!</p>";
            $this->result = false;
        }
    }
}
