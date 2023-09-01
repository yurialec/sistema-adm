<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListSituationPages;
use Core\ConfigView;

class ListSituationPages
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * @var int|string|null $page o número da página que o usuário está
     */
    private int|string|null $page;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listSitsPgs = new AdmsListSituationPages();
        $listSitsPgs->listSitsPgs($this->page);

        if ($listSitsPgs->getResult()) {
            $this->data['listSitsPgs'] = $listSitsPgs->getResultBd();
            $this->data['pagination'] = $listSitsPgs->getResultPg();
        } else {
            $this->data['listSitsPgs'] = [];
        }

        $this->data['sidebarActive'] = "list-situation-pages";

        $loadView = new ConfigView("adms/Views/SituationPages/ListSituationPages", $this->data);
        $loadView->loadView();
    }
}
