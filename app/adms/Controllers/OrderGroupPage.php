<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsOrderGroupPage;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Alterar Ordem do grupo de pagina
 * @author Yuri <yuri.alec@hotmail.com>
 */
class OrderGroupPage
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

            $viewGroupPage = new AdmsOrderGroupPage();
            $viewGroupPage->orderGroupPage($this->id);

            if ($viewGroupPage->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Grupo de página não encontrada!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
