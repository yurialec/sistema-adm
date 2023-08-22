<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsOrderTypePage;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Alterar Ordem do nível de acesso
 * @author Yuri <yuri.alec@hotmail.com>
 */
class OrderTypePgs
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

            $viewTypePage = new AdmsOrderTypePage();
            $viewTypePage->orderTypePage($this->id);

            if ($viewTypePage->getResult()) {
                $urlRedirect = URLADM . "list-types-pgs/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-types-pgs/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Tipo de página não encontrada!</p>";
            $urlRedirect = URLADM . "list-types-pgs/index";
            header("Location: $urlRedirect");
        }
    }
}
