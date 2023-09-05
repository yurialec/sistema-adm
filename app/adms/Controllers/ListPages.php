<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListPages;
use Core\ConfigView;

class ListPages
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

        $listPages = new AdmsListPages();
        $listPages->list($this->page);

        if ($listPages->getResult()) {
            $this->data['listPages'] = $listPages->getResultBd();
            $this->data['pagination'] = $listPages->getResultPg();
        } else {
            $this->data['listPages'] = [];
        }

        $this->data['sidebarActive'] = "list-pages";

        $loadView = new ConfigView("adms/Views/Pages/ListPages", $this->data);
        $loadView->loadView();
    }
}
