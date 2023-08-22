<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListGroupsPages;
use Core\ConfigView;

class ListGroupsPages
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
     * Metodo Visualizar tipode de pagina
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listGroupsPages = new AdmsListGroupsPages();
        $listGroupsPages->listTypesPgs($this->page);

        if ($listGroupsPages->getResult()) {
            $this->data['listGroupsPages'] = $listGroupsPages->getResultBd();
            $this->data['pagination'] = $listGroupsPages->getResultPg();
        } else {
            $this->data['listGroupsPages'] = [];
        }

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-groups-pages";

        $loadView = new ConfigView("adms/Views/GroupPages/ListGroupPages", $this->data);
        $loadView->loadView();
    }
}
