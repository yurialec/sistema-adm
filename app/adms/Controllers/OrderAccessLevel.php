<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsOrderAccessLevels;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Alterar Ordem do nível de acesso
 * @author Yuri <yuri.alec@hotmail.com>
 */
class OrderAccessLevel
{
    /** @var array|string|null $pag Recebe o número da pagina */
    private array|string|null $pag;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo alterar ordem
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        $this->pag  = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($id)) and (!empty($this->pag))) {
            $this->id = (int) $id;

            $viewAcessLevel = new AdmsOrderAccessLevels();
            $viewAcessLevel->orderAccessLevels($this->id);

            if ($viewAcessLevel->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Nível de Acesso não encontrado</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
