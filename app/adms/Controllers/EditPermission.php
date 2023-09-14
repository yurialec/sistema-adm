<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditColor;
use App\adms\Models\AdmsEditPermission;
use Core\ConfigView;

/**
 * Controller Editar permissao
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditPermission
{
    /** Recebe o id do registro @var integer|null */
    private string|int|null $id;

    /** Recebe o nivel de acesso @var integer|null */
    private string|int|null $level;

    /** Recebe o numero da pagina @var integer|null */
    private string|int|null $pag;

    /**
     * Metodo Login
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        $this->id = $id;
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($this->id)) and (!empty($this->level)) and (!empty($this->pag))) {

            $editPermission = new AdmsEditPermission;
            $editPermission->editPermission($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar a página para liberar permissão</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
